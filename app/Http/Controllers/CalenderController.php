<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function index()
    {
        // Fetch all doctor schedules
        $schedules = DoctorSchedule::all();

        // Prepare the events data
        $events = $schedules->map(function($schedule) {
            return [
                'title' => 'Dr. ' . $schedule->doctor->name, // Assuming you have a relationship with the Doctor model
                'start' => $schedule->available_date . 'T' . $schedule->start_time, // Format start datetime
                'end' => $schedule->available_date . 'T' . $schedule->end_time,     // Format end datetime
                'doctor_name' => 'Dr. ' . $schedule->doctor->name,
                'available_date' => $schedule->available_date,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'per_patient_time' => $schedule->per_patient_time,
            ];
        });

        // Return the events to the view
        return view('schedule.calendar', [
            'events' => $events
        ]);
    }
}

