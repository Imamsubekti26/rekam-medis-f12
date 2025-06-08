<?php

namespace App\Livewire\Components;

use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class DoctorScheduleForm extends Component
{
    public string $title = 'Tambah Jadwal Dokter';
    public User | Collection $doctors;

    public ?string $schedule_id;
    public ?string $doctor_id;
    public ?string $doctor_name;
    public ?string $available_date;
    public ?string $start_time;
    public ?string $end_time;
    public ?string $schedule_type;
    public ?int $handle_count;

    public function serialVisibilityChanged()
    {
        // do nothing just trigger livewire
    }

    public function mount(?DoctorSchedule $doctorSchedule)
    {
        $this->doctors = User::where('is_admin', false)->where('role', 'doctor')->get(); // ambil hanya dokter

        // kalau update, pakai id dari schedule
        if ($doctorSchedule->id) {
            $this->schedule_id = $doctorSchedule->id;
            $this->doctor_id = $doctorSchedule->doctor?->id;
            $this->doctor_name = $doctorSchedule->doctor?->name;
            $this->available_date = $doctorSchedule->available_date;
            $this->start_time = $doctorSchedule->start_time;
            $this->end_time = $doctorSchedule->end_time;
            $this->schedule_type = $doctorSchedule->schedule_type;
            $this->handle_count = $doctorSchedule->handle_count;
        } else {
            // kalau tambah, tergantung lu dokter atau admin
            $doctor = request()->user();
            if( $doctor->role == 'doctor') {
                $this->doctor_id = $doctor->id;
                $this->doctor_name = $doctor->name;
            }
        }
    }

    public function render()
    {
        return view('livewire.components.doctor-schedule-form');
    }
}
