<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Menampilkan daftar janji temu
    public function index(Request $request)
    {
        $query = Appointment::query();

        if ($request->user()->role == 'doctor') {
            $query = $query->where('doctor_id', $request->user()->id);
        }

        if ($request->has('search') && $request->search != null) {
            $query = $query->where('patient_name', 'like', '%' . $request->search . '%');
            $query = $query->orWhere('phone', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort_by') && $request->sort_by != null) {
            $sort = match ($request->sort_by) {
                'date_asc' => ['date', 'asc'],
                'date_desc' => ['date', 'desc'],
                'patient_name_asc' => ['patient_name', 'asc'],
                'patient_name_desc' => ['patient_name', 'desc'],
            };
            $query = $query->orderBy($sort[0], $sort[1]);
        } else {
            $query = $query->orderBy('created_at', 'desc');
        }

        try {
            $appointments = $query->paginate(10);
            return view('appointment.list', compact('appointments'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    // Menampilkan form untuk membuat janji temu baru
    public function create()
    {
        return view('appointment.create');
    }

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

    // Menampilkan form untuk mengedit janji temu
    public function edit(Appointment $appointment)
    {
        return view('appointment.edit', compact('appointment'));
    }

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
    public function printList(Request $request)
    {
        $query = Appointment::query();

        if ($request->has('search') && $request->search != null) {
            $query = $query->where('patient_name', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort_by') && $request->sort_by != null) {
            $sort = match ($request->sort_by) {
                'date_asc' => ['appointment_date', 'asc'],
                'date_desc' => ['appointment_date', 'desc'],
                'patient_name_asc' => ['patient_name', 'asc'],
                'patient_name_desc' => ['patient_name', 'desc'],
                default => ['created_at', 'desc'],
            };
            $query = $query->orderBy($sort[0], $sort[1]);
        } else {
            $query = $query->orderBy('created_at', 'desc');
        }

        $appointments = $query->get(); // Ambil semua data tanpa pagination

        return view('appointment.print-list', compact('appointments'));
    }
}
