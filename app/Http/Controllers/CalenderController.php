<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    // Untuk admin/petugas (akses dalam sistem)
    public function index()
    {
        return view('schedule.calendar', [
            'events' => $this->getFormattedSchedules()
        ]);
    }

    // Untuk publik (tanpa login)
    public function public()
    {
        return view('schedule.public', [
            'events' => $this->getFormattedSchedules()
        ]);
    }

    private function getFormattedSchedules()
    {
        return DoctorSchedule::with('doctor')->get()->map(function($schedule) {
            return [
                'title' => 'Dr. ' . $schedule->doctor->name,
                'start' => $schedule->available_date . 'T' . $schedule->start_time,
                'end' => $schedule->available_date . 'T' . $schedule->end_time,
                'doctor_name' => 'Dr. ' . $schedule->doctor->name,
                'available_date' => $schedule->available_date,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'handle_count' => $schedule->handle_count,
            ];
        });
    }
}


