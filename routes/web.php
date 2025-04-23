<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('patient/print', [PatientController::class, 'printList'])
    ->name('patient.print.list');

Route::resource('patient', PatientController::class)
    ->except(['edit'])
    ->middleware(['auth']);

Route::get('doctor/print', [DoctorController::class, 'printList'])
    ->name('doctor.print.list');

Route::resource('doctor', DoctorController::class)
    ->except(['edit'])
    ->middleware(['auth']);


Route::get('record/print', [MedicalRecordController::class, 'printList'])
    ->name('record.print.list');
Route::get('record/{record}/print', [MedicalRecordController::class, 'printDetail'])
    ->name('record.print.detail');

Route::resource('record', MedicalRecordController::class)
    ->except(['edit', 'store'])
    ->middleware(['auth']);

Route::get('medicine/print', [MedicineController::class, 'printList'])
    ->name('medicine.print.list');

Route::resource('medicine', MedicineController::class)
    ->except(['edit'])
    ->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
