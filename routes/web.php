<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::resource('patient', PatientController::class)
    ->except(['edit'])
    ->middleware(['auth']);

Route::resource('doctor', DoctorController::class)
    ->except(['edit'])
    ->middleware(['auth']);

Route::resource('record', MedicalRecordController::class)
    ->except(['edit', 'store'])
    ->middleware(['auth']);

Route::resource('medicine', MedicineController::class)
    ->except(['edit'])
    ->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
