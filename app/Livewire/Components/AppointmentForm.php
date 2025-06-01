<?php

namespace App\Livewire\Components;

use App\Livewire\BaseComponent;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Carbon\Carbon;

class AppointmentForm extends BaseComponent
{
    protected $rolePermission = ['doctor.viewer', 'pharmacist.editor'];

    public $appointmentId = '';
    public $patientName = '';
    public $phone = '';
    public $selectedDate = '';
    public $selectedTime = '';
    public $detail = '';
    public $status = 'pending';
    public $availableTime;
    public $disableTime = true;
    public $hasSubmitted = false;

    protected $rules = [
        'patientName' => ['required', 'string'],
        'phone' => ['required', 'numeric'],
        'selectedDate' => ['required', 'date', 'date_format:Y-m-d'],
        'selectedTime' => ['required', 'date_format:H:i'],
        'detail' => ['required', 'string'],
    ];

    public function getSchedules($whiteListTime = [])
    {
        // can't edit if has no permission
        if ($this->appointmentId !== '' && request()->user() && !request()->user()->is_editor) return;

        // cek jadwal pada hari x.
        $schedules = DoctorSchedule::where('available_date', $this->selectedDate)->get();

        if ($schedules->isEmpty()) {
            $this->availableTime = [];
            $this->disableTime = false;
            return;
        }

        // ambil jam paling awal dan paling akhir.
        $startTime = $schedules->min('start_time'); // ambil start_time terkecil
        $endTime = $schedules->max('end_time'); // ambil end_time terbesar

        // ambil durasi paling panjang.
        $sessionDuration = $schedules->max('per_patient_time'); // ambil per_patient_time terbesar

        // cek waktu yang udah di booking pada hari x
        $unavailableTime = Appointment::where('date', $this->selectedDate)->get(['time']);
        $unavailableTime = $unavailableTime->pluck('time')->map(fn($time) => substr((string) $time, 0, 5))->toArray();
        $unavailableTime = array_values(array_diff($unavailableTime, $whiteListTime));

        $this->availableTime = self::generateAvalilableTime($startTime, $endTime, $sessionDuration, 10, $unavailableTime);
        $this->disableTime = false;
    }

    public function submit()
    {
        $this->validate();
        $payload = [
            'patient_name' => $this->patientName,
            'phone' => $this->phone,
            'date' => $this->selectedDate,
            'time' => $this->selectedTime.':00',
            'detail' => $this->detail,
            'status' => $this->status,
        ];
        
        try {
            if ($this->appointmentId != '' && request()->user()) {
                if ($this->status != 'pending') {
                    $currentAppointment = Appointment::where('id', $this->appointmentId)->first(['date', 'time']);
                    $isDateChanged = $currentAppointment->date != $this->selectedDate;
                    $isTimeChanged = $currentAppointment->time != $this->selectedTime.':00';
    
                    // ubah jadi pending lagi kalau tgl/waktu janji temu berubah. biar bisa kirim WA konfirmasi lagi
                    if ($isDateChanged || $isTimeChanged) $payload['status'] = 'pending';
                }
                
                Appointment::where('id', $this->appointmentId)->update($payload);
            } else {
                Appointment::create($payload);
            }

            if (request()->user()) {
                return redirect()->route('appointment.index');
            } else {
                // TODO: send notification to pusher
                $this->hasSubmitted = true;
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    private static function generateAvalilableTime($startTime, $endTime, $sessionDuration, $breakDuration, $exclude = [])
    {
        $schedule = [];

        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);

        $current = $start;
        $blockDuration = $sessionDuration + $breakDuration;

        while ($current->copy()->lt($end)) {
            $formatted = $current->format('H:i');
            if (!in_array($formatted, $exclude)) {
                $schedule[] = $formatted;
            }
            $current->addMinutes($blockDuration);
        }

        return $schedule;
    }

    public function mount($appointment = null)
    {
        if (!$appointment) return;
        
        $formattedTime = Carbon::createFromFormat('H:i:s', $appointment->time)->format('H:i');
        $this->appointmentId = $appointment->id;
        $this->patientName = $appointment->patient_name;
        $this->phone = $appointment->phone;
        $this->selectedDate = $appointment->date;
        $this->selectedTime = $formattedTime;
        $this->detail = $appointment->detail;
        $this->status = $appointment->status;
        
        $this->disableTime = false;
        $this->getSchedules([$formattedTime]);
    }

    public function render()
    {
        return view('livewire.components.appointment-form');
    }
}
