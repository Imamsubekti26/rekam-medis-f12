@php
use Carbon\Carbon;
@endphp

<x-layouts.print>
    <h2 class="text-xl font-bold underline text-center mt-4">Daftar Rekam Medis</h2>
    <p class="text-sm mt-2 mb-4 text-center border-b border-gray-400 pb-1">Tanggal: {{ request()->query('date_start') ?? 'Awal' }} s/d {{ request()->query('date_end') ?? 'Sekarang' }} </p>
    
    <table class="w-full text-start mt-2 border border-gray-300 print:text-sm print:border-collapse">
        <thead class="bg-gray-100 print:bg-gray-200">
            <tr>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('medical_record.record_number') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('medical_record.date') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('patient.name') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('doctor.name') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('medical_record.anamnesis') }}
                    </div>
                </th>
            </tr>
        </thead>
        <tbody class="text-center border-b-1">
            @foreach ($records as $record)
                <tr class="odd:bg-white even:bg-gray-50 print:bg-white">
                    <td class="border border-gray-300 px-3 py-2">{{ $record->patient->no_rm }}</td>
                    <td class="border border-gray-300 px-3 py-2">
                        {{ Carbon::parse($record->date)->setTimezone('Asia/Jakarta')->format('y/m/d H:i') }}
                    </td>
                    <td class="border border-gray-300 px-3 py-2">{{ $record->patient->name }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $record->doctor->name }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $record->anamnesis }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.print>
