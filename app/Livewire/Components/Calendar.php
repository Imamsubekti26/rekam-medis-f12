<?php

namespace App\Livewire\Components;

use App\Models\DoctorSchedule;
use Livewire\Component;

class Calendar extends Component
{
    public $events;
    public $selectedSchedule;

    public $today;

    public $selectedDoctor = ['id' => '', 'name' => ''];

    private function getFormattedSchedules()
    {
        return DoctorSchedule::with('doctor')->get()->map(function($schedule) {
            return [
                'id' => $schedule->id,
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

    public function getDaySchedules($event)
    {
        $this->today = $event['dateStr'];
        $this->selectedSchedule = DoctorSchedule::with('doctor')->withCount('appointments')->where('available_date', $event['dateStr'])->get();
    }

    public function showModalDialog(?DoctorSchedule $doctorSchedule)
    {
        if (!$doctorSchedule->id) return;
        $this->dispatch('appointment-pre-data', doctorSchedule: $doctorSchedule->id);
    }

    public function mount()
    {
        $this->events = $this->getFormattedSchedules();

        $this->today = \Carbon\Carbon::today()->format('Y-m-d');
        $payload = [
            'dateStr' => $this->today
        ];
        $this->getDaySchedules($payload);
    }

    public function render()
    {
        return view('livewire.components.calendar');
    }
}
