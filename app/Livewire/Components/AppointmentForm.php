<?php

namespace App\Livewire\Components;

use App\Livewire\BaseComponent;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use Carbon\Carbon;
use Livewire\Attributes\On;

class AppointmentForm extends BaseComponent
{
    protected $rolePermission = ['doctor.viewer', 'pharmacist.editor'];

    public $appointmentId;
    public $schedule;
    public $patientNIK = '';
    public $doctor_id = '';
    public $doctor_name = '';
    public $doctor_use_select = ''; // sebagai penanda nama dokter mau pakai input atau select
    public $doctorList = []; // opsi untuk form select dokter
    public $patientId = '';
    public $patientName = '';
    public $phone = '';
    public $selectedDate = '';
    public $disableDate = false;
    public $selectedTime = '';
    public $disableTime = true;
    public $isRandomVisibility = false;
    public $detail = '';
    public $status = 'pending';
    public $availableTime = [];
    public $hasSubmitted = false;

    protected $rules = [
        'patientNIK' => ['required', 'numeric', 'digits:16'],
        'doctor_id' => ['required', 'string'],
        'patientName' => ['required', 'string'],
        'phone' => ['required', 'numeric'],
        'selectedDate' => ['required', 'date', 'date_format:Y-m-d'],
        'selectedTime' => ['required', 'date_format:H:i'],
        'detail' => ['required', 'string'],
    ];

    public function getSchedules($whiteListTime = [])
    {
        // pastikan data dokter dan waktu ada
        if (!$this->doctor_id || !$this->selectedDate) return;
        
        // enable pemilihan waktu
        $this->disableTime = false;

        // jika schedule tidak spesifik
        if (!$this->schedule || $this->appointmentId) {
            // cek jadwal pada hari x. untuk dokter y
            $schedules = DoctorSchedule::where('available_date', $this->selectedDate)
                ->where('doctor_id', $this->doctor_id )
                ->get();
            $scheduleCount = count($schedules);

            // kalo bukan jadwal tunggal, kasih random aja
            if ($scheduleCount != 1) $this->isRandomVisibility = true;

            // jika tidak ada jadwal, return aja, jika ada ambil data pertama
            if ($scheduleCount == 0) return;
            $this->schedule = $schedules[0];
        }

        // cek kalo random tidak usah diterusin
        $this->isRandomVisibility =  $this->schedule->schedule_type == 'Random';
        if ($this->isRandomVisibility) return;

        // ambil jam mulai, jam berakhir, dan handle time per sesi.
        $startTime = $this->schedule->start_time;
        $endTime = $this->schedule->end_time;
        $sessionDuration = $this->schedule->handle_count;

        // include data selected time yang tersimpan di db
        if($this->appointmentId) {
            array_push($whiteListTime, $this->selectedTime);
        }

        // cek waktu yang udah di booking pada hari x
        $unavailableTime = Appointment::where('date', $this->selectedDate)->get(['time']);
        $unavailableTime = $unavailableTime->pluck('time')->map(fn($time) => substr((string) $time, 0, 5))->toArray();
        $unavailableTime = array_values(array_diff($unavailableTime, $whiteListTime));

        $this->availableTime = self::generateAvalilableTime($startTime, $endTime, $sessionDuration, 0, $unavailableTime);
    }

    private function parseNIK($nik) {
        // Pastikan NIK 16 digit dan hanya angka
        if (!preg_match('/^[0-9]{16}$/', $nik)) {
            return ['error' => 'Format NIK tidak valid'];
        }
    
        // Ambil bagian tanggal lahir (6 digit setelah kode wilayah)
        $date = substr($nik, 6, 2);
        $month = substr($nik, 8, 2);
        $tahun = substr($nik, 10, 2);
    
        // Cek jenis kelamin (tanggal > 40 = perempuan)
        $is_male = (int)$date <= 40;
        
        // Normalisasi tanggal untuk perempuan (dikurangi 40)
        if (!$is_male) {
            $date = (int)$date - 40;
            $date = str_pad($date, 2, '0', STR_PAD_LEFT); // Format 2 digit
        }
    
        // Konversi tahun (asumsi abad 20 atau 21)
        $fullYear = ($tahun <= (int)date('y')) 
            ? '20' . $tahun  // 2000 - sekarang
            : '19' . $tahun; // 1900 - 1999
    
        // Validasi tanggal
        if (!checkdate((int)$month, (int)$date, (int)$fullYear)) {
            return ['error' => 'Tanggal lahir tidak valid'];
        }
    
        // Format output
        return [
            'date_of_birth' => "$fullYear-$month-$date",
            'is_male' => $is_male,
            'error' => null
        ];
    }

    public function submit()
    {
        $this->validate();
        $payload = [
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
                // cek apa pasien dg NIK terkait sudah terdaftar, kalau belum daftarin dulu
                $patient = $this->parseNIK($this->patientNIK);

                if($patient['error']) {
                    $this->addError('patientNIK', $patient['error']);
                    return;
                }

                $patient = Patient::firstOrCreate(
                    ['nik' => $this->patientNIK],
                    [
                        'name' => $this->patientName,
                        'phone' => $this->phone,
                        'is_male' => $patient['is_male'],
                        'date_of_birth' => $patient['date_of_birth'],
                    ]
                );

                $payload['patient_id'] = $patient->id;
                $payload['doctor_id'] = $this->doctor_id;
                $payload['phone'] = $this->phone;
                if ($this->schedule) $payload['schedule_id'] = $this->schedule->id;

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

    // ini mount buat sisi pasien
    #[On('appointment-pre-data')]
    public function setData(DoctorSchedule $doctorSchedule)
    {
        // aturan disable: disable tanggal enable time disable doctor
        $this->disableDate = true;
        $this->disableTime = false;
        $this->doctor_use_select = false;

        // isi data sesuai jadwal yg dipilih
        $this->schedule = $doctorSchedule;
        $this->doctor_id = $doctorSchedule->doctor->id;
        $this->doctor_name = $doctorSchedule->doctor->name;
        $this->selectedDate = $doctorSchedule->available_date;
        $this->isRandomVisibility = $doctorSchedule->schedule_type != 'Sequential';
        $this->getSchedules();
    }

    // ini mount buat sisi dashboard
    public function mount(?Appointment $appointment)
    {
        // cak apakah ini update mode atau insert mode
        if (!$appointment->id) return;

        // isi formnya dengan data yang mau diupdate
        $this->appointmentId = $appointment->id;
        $this->patientNIK = $appointment->patient->nik;
        $this->doctor_id = $appointment->doctor->id;
        $this->doctor_name = $appointment->doctor->name;
        $this->patientName = $appointment->patient->name;
        $this->phone = $appointment->phone;
        $this->selectedDate = $appointment->date;
        $this->selectedTime = Carbon::createFromFormat('H:i:s', $appointment->time)->format('H:i');
        $this->detail = $appointment->detail;

        $this->schedule = $appointment->schedule;
        
        $this->disableTime = false;
        $this->getSchedules();
    }

    public function render()
    {
        return view('livewire.components.appointment-form');
    }
}
