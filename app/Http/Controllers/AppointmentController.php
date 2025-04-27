<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Menampilkan daftar janji temu
    public function index()
    {
        // Mengambil semua janji temu
        // $appointments = Appointment::all();

        // Mengembalikan tampilan dengan data janji temu
        return view('appointment.list');
    }

    // // Menampilkan form untuk membuat janji temu baru
    // public function create()
    // {
    //     return view('appointments.create');
    // }

    // // Menyimpan janji temu baru ke database
    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'doctor_name' => 'required|string|max:255',
    //         'patient_name' => 'required|string|max:255',
    //         'appointment_date' => 'required|date',
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i|after:start_time',
    //     ]);

    //     // Membuat janji temu baru
    //     Appointment::create([
    //         'doctor_name' => $request->doctor_name,
    //         'patient_name' => $request->patient_name,
    //         'appointment_date' => $request->appointment_date,
    //         'start_time' => $request->start_time,
    //         'end_time' => $request->end_time,
    //     ]);

    //     // Mengarahkan ke halaman daftar janji temu dengan pesan sukses
    //     return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil dibuat!');
    // }

    // // Menampilkan form untuk mengedit janji temu
    // public function edit($id)
    // {
    //     $appointment = Appointment::findOrFail($id);
    //     return view('appointments.edit', compact('appointment'));
    // }

    // // Memperbarui data janji temu
    // public function update(Request $request, $id)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'doctor_name' => 'required|string|max:255',
    //         'patient_name' => 'required|string|max:255',
    //         'appointment_date' => 'required|date',
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i|after:start_time',
    //     ]);

    //     // Menemukan janji temu dan memperbarui data
    //     $appointment = Appointment::findOrFail($id);
    //     $appointment->update([
    //         'doctor_name' => $request->doctor_name,
    //         'patient_name' => $request->patient_name,
    //         'appointment_date' => $request->appointment_date,
    //         'start_time' => $request->start_time,
    //         'end_time' => $request->end_time,
    //     ]);

    //     // Mengarahkan kembali dengan pesan sukses
    //     return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil diperbarui!');
    // }

    // // Menghapus janji temu
    // public function destroy($id)
    // {
    //     $appointment = Appointment::findOrFail($id);
    //     $appointment->delete();

    //     // Mengarahkan kembali dengan pesan sukses
    //     return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil dihapus!');
    // }
}
