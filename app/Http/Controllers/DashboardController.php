<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalDoctors = User::where('is_admin', false)->count();
        $totalPatients = Patient::count();
        $totalMedicalRecords = MedicalRecord::count();
        $totalMedicineStock = Medicine::sum('stock');

        $totalMalePatients = Patient::where('is_male', true)->count();
        $totalFemalePatients = Patient::where('is_male', false)->count();

        $newDoctorsToday = User::where('is_admin', false)->whereDate('created_at', $today)->count();
        $newPatientsToday = Patient::whereDate('created_at', $today)->count();
        $newMedicalRecordsToday = MedicalRecord::whereDate('created_at', $today)->count();
        $newMedicineStockToday = Medicine::whereDate('created_at', $today)->sum('stock');

        // Ambil umur pasien dan kelompokkan berdasarkan range umur
        $patients = Patient::selectRaw("TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) as age, is_male")
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
                if ($patient->age >= $min && $patient->age <= $max) {
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

        return view('dashboard', compact(
            'totalDoctors',
            'totalPatients',
            'totalMedicalRecords',
            'totalMedicineStock',
            'newDoctorsToday',
            'newPatientsToday',
            'newMedicalRecordsToday',
            'newMedicineStockToday',
            'totalMalePatients',
            'totalFemalePatients',
            'rangeLabels',
            'maleCounts',
            'femaleCounts'
        ));
    }
}
