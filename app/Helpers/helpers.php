<?php

if (!function_exists('normalizePhoneNumber')) {
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