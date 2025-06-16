<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardPharmacistController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        // Ambil semua resep hari ini
        $todayPrescriptionsRaw = Prescription::with([
            'medicine',
            'medical_record.patient',
        ])->whereDate('created_at', now()->toDateString())
            ->get();

        // Format ulang data seperti di CardPrescription
        $todayPrescriptions = $todayPrescriptionsRaw->map(function ($p) {
            return [
                'id' => $p->id,
                'medicine_id' => $p->medicine_id,
                'medicine_name' => $p->medicine->name ?? '-',
                'rule_of_use' => $p->rule_of_use,
                'aftermeal' => $p->aftermeal,
                'notes' => $p->notes,
                'patient_name' => $p->medical_record->patient->name ?? '-',
            ];
        });

        $lowStockMedicines = Medicine::where('stock', '<', 10)->get();
        $totalPrescriptionsToday = $todayPrescriptions->count();
        $totalMedicines = Medicine::count();

        // Janji temu hari ini
        $appointments = Appointment::with('patient')
            ->where('date', $today->toDateString())
            ->orderBy('time')
            ->get();

        $upcomingAppointments = Appointment::with('patient')
            ->whereDate('date', '>', Carbon::today())
            ->orderBy('date')
            ->orderBy('time')
            ->take(5)
            ->get();


        $totalAppointmentsAllTime = Appointment::count();
        $appointmentsApproved = Appointment::where('status', 'approved')->count();
        $appointmentsPending = Appointment::where('status', 'pending')->count();
        $appointmentsRejected = Appointment::where('status', 'rejected')->count();
        $totalAppointments = $appointments->count();
        $totalCompleted = $appointments->where('status', 'approved')->count();
        $totalPending = $appointments->where('status', 'pending')->count();
        $totalCanceled = $appointments->where('status', 'rejected')->count();

        return view('dashboardpharmacist', [
            'todayPrescriptions' => $todayPrescriptions,
            'lowStockMedicines' => $lowStockMedicines,
            'totalPrescriptionsToday' => $totalPrescriptionsToday,
            'totalMedicines' => $totalMedicines,
            'appointments' => $appointments,
            'totalAppointments' => $totalAppointments,
            'totalCompleted' => $totalCompleted,
            'totalPending' => $totalPending,
            'totalCanceled' => $totalCanceled,
            'totalAppointmentsAllTime' => $totalAppointmentsAllTime,
            'appointmentsApproved' => $appointmentsApproved,
            'appointmentsPending' => $appointmentsPending,
            'appointmentsRejected' => $appointmentsRejected,
            'upcomingAppointments' => $upcomingAppointments
        ]);
    }
}
