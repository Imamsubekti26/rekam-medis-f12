<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
use App\Http\Middleware\AdminRestriction;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard Routes
Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Patient Routes
Route::get('patient/print', [PatientController::class, 'printList'])
    ->name('patient.print.list')
    ->middleware(['auth', AdminRestriction::class]);
Route::resource('patient', PatientController::class)
    ->except(['edit'])
    ->middleware(['auth']);

// Doctor Routes
Route::get('doctor/print', [DoctorController::class, 'printList'])
    ->name('doctor.print.list')
    ->middleware(['auth', AdminRestriction::class]);
Route::resource('doctor', DoctorController::class)
    ->except(['edit'])
    ->middleware(['auth', AdminRestriction::class]);

// Medical Record Routes
Route::get('record/print', [MedicalRecordController::class, 'printList'])
    ->name('record.print.list')
    ->middleware(['auth']);
Route::get('record/{record}/print', [MedicalRecordController::class, 'printDetail'])
    ->name('record.print.detail')
    ->middleware(['auth']);
Route::resource('record', MedicalRecordController::class)
    ->except(['edit', 'store'])
    ->middleware(['auth']);

// Medicine Routes
Route::get('medicine/print', [MedicineController::class, 'printList'])
    ->name('medicine.print.list')
    ->middleware(['auth', AdminRestriction::class]);
Route::resource('medicine', MedicineController::class)
    ->except(['edit'])
    ->middleware(['auth', AdminRestriction::class]);

Route::resource('schedule', ScheduleController::class)
    ->except(['edit'])
    ->middleware(['auth']);

Route::resource('appointment', AppointmentController::class)
    ->except(['edit'])
    ->middleware(['auth']);

Route::get('calendar', [CalenderController::class, 'index'])
    ->middleware('auth')
    ->name('schedule.calendar');


// Setting Routes
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
