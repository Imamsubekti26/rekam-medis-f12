<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('normalizePhoneNumber')) {
    /**
     * Normalisasi nomor telepon agar 08123...
     * @param mixed $number
     * @return array|string|null
     */
    function normalizePhoneNumber($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (substr($number, 0, 2) === '62') {
            $number = '0' . substr($number, 2);
        } elseif (substr($number, 0, 3) === '620') {
            $number = '0' . substr($number, 3);
        }

        return $number;
    }
}

if (!function_exists('toWhatsappNumber')) {
    /**
     * Normalisasikan nomor whatsapp agar 62123...
     * @param mixed $number
     * @return array|string|null
     */
    function toWhatsappNumber($number)
    {
        // Gunakan normalizePhoneNumber dulu
        $number = normalizePhoneNumber($number);

        // Ubah 08 ke 628
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }

        return $number;
    }
}

if (!function_exists('parseNIK')) {
    /**
     * Ambil tanggal lahir dan gender dari NIK
     * @param mixed $nik
     * @return array{date_of_birth: string, error: string|null, is_male: bool}
     */
    function parseNIK($nik) {
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
        $fullYear = ($tahun <= (int)date('y')) ? "20$tahun" : "19$tahun";
    
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
}