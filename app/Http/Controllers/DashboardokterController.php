<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardokterController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfWeek = $today->copy()->startOfWeek(); // Senin
        $endOfWeek = $today->copy()->endOfWeek();     // Minggu
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

        $doctorId = Auth::id();

        // Jadwal Hari Ini
        $appointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->where('date', $today->toDateString())
            ->orderBy('time')
            ->get();

        // Riwayat Pemeriksaan Terkini
        $recentRecords = MedicalRecord::with('patient')
            ->where('doctor_id', $doctorId)
            ->orderByDesc('date')
            ->limit(5)
            ->get();

        // 📊 Statistik:

        // 1. Jumlah Pasien Diperiksa (dari rekam medis)
        $patientsExaminedToday = MedicalRecord::where('doctor_id', $doctorId)
            ->whereDate('date', $today)
            ->count();

        $patientsExaminedThisWeek = MedicalRecord::where('doctor_id', $doctorId)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->count();

        $patientsExaminedThisMonth = MedicalRecord::where('doctor_id', $doctorId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->count();

        // 2. Jumlah Janji Temu Terjadwal
        $appointmentsToday = Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', $today)
            ->count();

        $appointmentsThisWeek = Appointment::where('doctor_id', $doctorId)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->count();

        // Status Janji Temu Hari Ini
        $appointmentStatusCounts = Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', $today)
            ->selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // 4. Jadwal Dokter Terdekat
        $doctorSchedules = DoctorSchedule::where('doctor_id', $doctorId)
            ->whereDate('available_date', '>=', $today)
            ->orderBy('available_date')
            ->withCount('appointments')
            ->limit(5)
            ->get();


        // 3. Jumlah Resep Dibuat
        $prescriptionsToday = Prescription::whereDate('created_at', $today)
            ->whereHas('medical_record', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })->count();

        $prescriptionsThisWeek = Prescription::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->whereHas('medical_record', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })->count();

        $prescriptionsThisMonth = Prescription::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereHas('medical_record', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })->count();

        return view('dashboardokter', compact(
            'appointments',
            'recentRecords',
            'patientsExaminedToday',
            'patientsExaminedThisWeek',
            'patientsExaminedThisMonth',
            'appointmentsToday',
            'appointmentsThisWeek',
            'appointmentStatusCounts',
            'prescriptionsToday',
            'prescriptionsThisWeek',
            'prescriptionsThisMonth',
            'doctorSchedules'
        ));
    }
}
