<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;

class DashboardPharmacistController extends Controller
{
    public function index()
    {
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

        return view('dashboardpharmacist', [
            'todayPrescriptions' => $todayPrescriptions,
            'lowStockMedicines' => $lowStockMedicines,
            'totalPrescriptionsToday' => $totalPrescriptionsToday,
            'totalMedicines' => $totalMedicines,
        ]);
    }
}
