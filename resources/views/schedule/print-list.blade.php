@php
use Carbon\Carbon;
@endphp

<x-layouts.print>
    <h2 class="text-xl font-bold underline text-center mt-4">Daftar Jadwal Dokter</h2>
    <p class="text-sm mt-2 mb-4 text-center border-gray-400 pb-1">
        Tanggal Cetak: {{ Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }} 
    </p>

    <table class="w-full text-start mt-2 border border-gray-300 print:text-sm print:border-collapse">
        <thead class="bg-gray-100 print:bg-gray-200">
            <tr>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        No
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        Dokter
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        Tanggal
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        Waktu Mulai
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        Waktu Selesai
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        Durasi Per-pasien
                    </div>
                </th>
            </tr>
        </thead>
        <tbody class="text-center border-b-1">
            @foreach ($schedules as $schedule)
                <tr class="odd:bg-white even:bg-gray-50 print:bg-white">
                    <td class="border border-gray-300 px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $schedule->doctor->name ?? '-' }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ Carbon::parse($schedule->available_date)->translatedFormat('l, d F Y') }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $schedule->per_patient_time }} menit</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.print>
