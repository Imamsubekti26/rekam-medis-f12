<?php

namespace App\Livewire\Components;

use App\Livewire\BaseComponent;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentWhatsappConfirm extends BaseComponent
{

    protected $rolePermission = ['pharmacist.editor', 'doctor.viewer'];

    private string $apotekName = "Apotek F21 Minomartani";
    public string $whatsappMessage = '';
    public string $whatsappNumber = '';
    public string $type = "approve";
    public string $error = '';
    public string $appointmentId = '';

    public function submit()
    {
        // Ensure user have access to apporve/reject appointment
        if (!request()->user()->is_editor) return;

        // Validasi atau simpan dulu kalau perlu
        $this->validate([
            'whatsappMessage' => 'required|string',
        ]);

        try {
            // update data di DB
            if ($this->type == 'approve') {
                Appointment::where('id', $this->appointmentId)->update(['status' => 'approved']);
            } else {
                Appointment::where('id', $this->appointmentId)->update(['status' => 'rejected']);
            }

            // Emit event untuk frontend agar buka tab baru
            $this->dispatch('whatsapp:send', [
                'number' => $this->whatsappNumber,
                'message' => $this->whatsappMessage,
            ]);
        } catch (\Exception $e) {
            $this->error = "Gagal melakukan aksi, refresh halaman ini lalu coba lagi beberapa saat.";
            dd($e);
        }
    }

    public function mount($appointment, string $type = "approve")
    {
        $this->type = $type;
        $this->whatsappNumber = toWhatsappNumber($appointment->phone);
        $this->appointmentId = $appointment->id;

        $date = Carbon::parse($appointment->date)->translatedFormat('l, d F Y');
        $time = Carbon::createFromFormat('H:i:s', $appointment->time)->format('H.i');
        
        // ⚠️ NOTE ⚠️
        // pesan dibawah JANGAN DIKASIH 'ENTER'. nanti bakal kedetek sama textarea!
        // kalau mau lihatnya sedikit lebih enak, aktifkan word wrap di vscode => alt + Z

        $approveMsg = "Halo *{$appointment->patient->name}*,\n\nTerima kasih telah mengajukan permintaan janji temu dengan dokter kami di *$this->apotekName*.\n\nKami konfirmasi bahwa permintaan Anda telah *disetujui*.\n\nTanggal: $date\nWaktu: $time\n\nSilakan datang sesuai jadwal. Jika ada perubahan, silakan hubungi kami dengan membalas pesan ini.\n\nTerima kasih, salam sehat.";

        $rejectMsg = "Halo *{$appointment->patient->name}*,\n\nTerima kasih atas permintaan janji temu Anda dengan dokter kami di *$this->apotekName*.\nMohon maaf, saat ini *kami belum bisa melakukan janji temu sesuai jadwal yang Anda pilih*.\n\nTanggal: $date\nWaktu: $time\n\nDengan alasan *dokter sedang tidak di tempat*.\nJika anda ingin *menjadwalkan ulang* janji temu Anda, balas pesan ini dengan ketik *Setuju*\n\nTerima kasih atas pengertiannya.";

        $this->whatsappMessage = $type == "approve" ? $approveMsg : $rejectMsg;
    }

    public function render()
    {
        return view('livewire.components.appointment-whatsapp-confirm');
    }
}
