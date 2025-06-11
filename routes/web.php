<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardokterController;
use App\Http\Controllers\DashboardPharmacistController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\ScheduleController;
use App\Http\Middleware\RoleRestriction;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/kontakami', function () {
    return view('contact');
})->name('kontak');

Route::get('/daftar', function () {
    return view('welcome3');
})->name('calendar_public');

// Dashboard Routes
Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboardokter', [DashboardokterController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboardokter');

Route::get('/dashboardpharmacist', [DashboardPharmacistController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboardpharmacist');

// Patient Routes
Route::get('record/print/{patient}', [PatientController::class, 'printByPatient'])
    ->name('record.print.by_patient')
    ->middleware(['auth']);
Route::get('patient/print', [PatientController::class, 'printList'])
    ->name('patient.print.list')
    ->middleware(['auth']);
Route::resource('patient', PatientController::class)
    ->except(['edit'])
    ->middleware(['auth']);

// Doctor Routes
Route::get('doctor/print', [DoctorController::class, 'printList'])
    ->name('doctor.print.list')
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.viewer,doctor.viewer']);
Route::resource('doctor', DoctorController::class)
    ->except(['edit'])
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.viewer,doctor.viewer']);

// Pharmacist Routes
Route::get('pharmacist/print', [PharmacistController::class, 'printList'])
    ->name('pharmacist.print.list')
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.viewer,doctor.viewer']);
Route::resource('pharmacist', PharmacistController::class)
    ->except(['edit'])
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.viewer,doctor.viewer']);

// Medical Record Routes
Route::get('record/print', [MedicalRecordController::class, 'printList'])
    ->name('record.print.list')
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.viewer,doctor.editor']);
Route::get('record/{record}/print', [MedicalRecordController::class, 'printDetail'])
    ->name('record.print.detail')
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.viewer,doctor.editor']);
Route::resource('record', MedicalRecordController::class)
    ->except(['edit', 'store'])
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.viewer,doctor.editor']);

// Medicine Routes
Route::get('medicine/print', [MedicineController::class, 'printList'])
    ->name('medicine.print.list')
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.editor,doctor.viewer']);
Route::resource('medicine', MedicineController::class)
    ->except(['edit'])
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.editor,doctor.viewer']);

// Schedule Routes
Route::get('schedule/print', [ScheduleController::class, 'printList'])
    ->name('schedule.print.list');
Route::resource('schedule', ScheduleController::class)
    ->except(['edit'])
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.viewer,doctor.editor']);

// Appointment Routes
Route::get('appointment/print', [AppointmentController::class, 'printList'])
    ->name('appointment.print.list');
Route::resource('appointment', AppointmentController::class)
    ->except(['show'])
    ->middleware(['auth', RoleRestriction::class . ':pharmacist.editor,doctor.viewer']);

Route::get('calendar', [CalenderController::class, 'index'])
    ->middleware('auth')
    ->name('schedule.calendar');

Route::get('/jadwalpublik', [CalenderController::class, 'public'])
    ->name('schedule.public');


// Setting Routes
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
