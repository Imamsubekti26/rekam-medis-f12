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
    /**
     * Menampilkan dashboard dengan akumulasi data dan tambahan data hari ini.
     */
    public function index()
    {
        $today = Carbon::today();
        
        $totalDoctors = User::where('is_admin', false)->count();
        $totalPatients = Patient::count();
        $totalMedicalRecords = MedicalRecord::count();
        $totalMedicineStock = Medicine::sum('stock');
        
        // Data yang ditambahkan hari ini
        $newDoctorsToday = User::where('is_admin', false)->whereDate('created_at', $today)->count();
        $newPatientsToday = Patient::whereDate('created_at', $today)->count();
        $newMedicalRecordsToday = MedicalRecord::whereDate('created_at', $today)->count();
        $newMedicineStockToday = Medicine::whereDate('created_at', $today)->sum('stock');

        return view('dashboard', compact(
            'totalDoctors', 'totalPatients', 'totalMedicalRecords', 'totalMedicineStock',
            'newDoctorsToday', 'newPatientsToday', 'newMedicalRecordsToday', 'newMedicineStockToday'
        ));
    }
}
?>
