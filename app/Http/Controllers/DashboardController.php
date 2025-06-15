<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\User;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $range = $request->get('range', 'months');

        $totalDoctors = User::where('is_admin', false)
                    ->where('role', '!=', 'pharmacist')
                    ->count();

        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();
        $totalMedicalRecords = MedicalRecord::count();
        $totalMedicineStock = Medicine::count();

        $totalMalePatients = Patient::where('is_male', true)->count();
        $totalFemalePatients = Patient::where('is_male', false)->count();

        $schedulesToday = DoctorSchedule::whereDate('available_date', $today)->count();
        $newPatientsToday = Patient::whereDate('created_at', $today)->count();
        $newAppointmentsToday = Appointment::whereDate('date', $today)->count();
        $newMedicalRecordsToday = MedicalRecord::whereDate('created_at', $today)->count();
        $newMedicineStockToday = Medicine::whereDate('created_at', $today)->count();

        // Ambil umur pasien dan kelompokkan berdasarkan range umur
        $patients = Patient::select(['is_male', 'date_of_birth'])
            ->whereNotNull('date_of_birth')
            ->get();

        $ranges = [
            '1-10' => [1, 10],
            '11-20' => [11, 20],
            '21-30' => [21, 30],
            '31-40' => [31, 40],
            '41-50' => [41, 50],
            '51-60' => [51, 60],
            '61-70' => [61, 70],
            '71+' => [71, 200],
        ];

        $rangeLabels = array_keys($ranges);
        $maleCounts = array_fill(0, count($ranges), 0);
        $femaleCounts = array_fill(0, count($ranges), 0);

        foreach ($patients as $patient) {
            foreach ($ranges as $label => [$min, $max]) {
                if ($patient->date_of_birth->age >= $min && $patient->date_of_birth->age <= $max) {
                    $index = array_search($label, $rangeLabels);
                    if ($patient->is_male) {
                        $maleCounts[$index]++;
                    } else {
                        $femaleCounts[$index]++;
                    }
                    break;
                }
            }
        }

        // === Persiapan data chart berdasarkan range
        $chartLabels = collect();
        $chartData = collect();

        switch ($range) {
            case 'days':
                for ($i = 6; $i >= 0; $i--) {
                    $chartLabels->push(now()->subDays($i)->format('d M'));
                }

                $records = MedicalRecord::where('date', '>=', now()->subDays(6)->startOfDay())
                    ->get()
                    ->groupBy(function ($record) {
                        return $record->date->format('d M');
                    })
                    ->map->count();

                $chartData = $chartLabels->map(fn($label) => $records[$label] ?? 0);
                break;

            case 'weeks':
                $chartLabels = collect();
                
                // Buat label minggu terakhir secara dinamis
                for ($i = 6; $i >= 0; $i--) {
                    $weekStart = now()->subWeeks($i)->startOfWeek();
                    $yearWeek = $weekStart->format('oW'); // Tahun ISO + Minggu (misal: 202415)
                    $label = $i === 0 ? 'Minggu ini' : ($i === 1 ? '1 minggu lalu' : "$i minggu lalu");
                    $chartLabels->push([
                        'label' => $label,
                        'key' => $yearWeek
                    ]);
                }
                
                // Get records
                $records = MedicalRecord::where('date', '>=', now()->subWeeks(6)->startOfWeek())
                    ->get()
                    ->groupBy(function ($record) {
                        return $record->date->startOfWeek()->format('oW');
                    })
                    ->map->count();
                
                $chartData = $chartLabels->map(fn($item) => $records[$item['key']] ?? 0);
                    $chartLabels = $chartLabels->pluck('label'); // Ambil hanya label untuk Chart.js
                
                break;

            case 'years':
                for ($i = 6; $i >= 0; $i--) {
                    $chartLabels->push(now()->subYears($i)->format('Y'));
                }

                $records = MedicalRecord::where('date', '>=', now()->subYears(6)->startOfYear())
                    ->get()
                    ->groupBy(function ($record) {
                        return $record->date->format('Y');
                    })
                    ->map->count();

                $chartData = $chartLabels->map(fn($label) => $records[$label] ?? 0);
                break;

            default: // 'months'
                for ($i = 6; $i >= 0; $i--) {
                    $chartLabels->push(now()->subMonths($i)->format('M Y'));
                }

                $records = MedicalRecord::where('date', '>=', now()->subMonths(6)->startOfMonth())
                    ->get()
                    ->sortBy('date')
                    ->groupBy(function ($record) {
                        return $record->date->format('M Y');
                    })
                    ->map->count();

                $chartData = $chartLabels->map(fn($label) => $records[$label] ?? 0);
                break;
        }

        return view('dashboard', compact(
            'totalDoctors',
            'totalPatients',
            'totalAppointments',
            'totalMedicalRecords',
            'totalMedicineStock',
            'schedulesToday',
            'newPatientsToday',
            'newAppointmentsToday',
            'newMedicalRecordsToday',
            'newMedicineStockToday',
            'totalMalePatients',
            'totalFemalePatients',
            'rangeLabels',
            'maleCounts',
            'femaleCounts',
            'chartLabels',
            'chartData'
        ));
    }
}
