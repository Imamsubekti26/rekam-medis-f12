<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard dengan akumulasi data.
     */
    public function index()
    {
        $totalDoctors = User::where('is_admin', false)->count();
        $totalPatients = Patient::count();
        $totalMedicalRecords = MedicalRecord::count();
        $totalMedicineStock = Medicine::sum('stock');

        return view('dashboard', compact('totalDoctors', 'totalPatients', 'totalMedicalRecords', 'totalMedicineStock'));
    }
}
