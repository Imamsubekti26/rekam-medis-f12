@php
use Carbon\Carbon;
@endphp

<x-layouts.print>
    <h2 class="text-xl font-bold underline text-center mt-4">Daftar Data Pasien</h2>
    <p class="text-sm mt-2 mb-4 text-center border-gray-400 pb-1">
        Tanggal Cetak: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }} 
    </p>
    <table class="w-full text-start mt-2 border border-gray-300 print:text-sm print:border-collapse">
        <thead class="bg-gray-100 print:bg-gray-200">
            <tr>
                <th class="border border-gray-300 px-3 py-2 text-left w-1/8">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('patient.member_id') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left w-1/4">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('patient.name') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left w-1/6">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('patient.gender') }}/{{ __('patient.age') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left w-1/6">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('patient.phone') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left w-2/5">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('patient.address') }}
                    </div>
                </th>
            </tr>
        </thead>
        <tbody class="text-center border-b-1">
            @foreach ($patients as $patient)
                <tr class="odd:bg-white even:bg-gray-50 print:bg-white">
                    <td class="border border-gray-300 px-3 py-2">{{ $patient->member_id }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $patient->name }}</td>
                    <td class="border border-gray-300 px-3 py-2 text-sm">
                        {{ $patient->is_male ? 'L' : 'P' }} /
                        {{ Carbon::createFromDate($patient->date_of_birth)->age }}
                    </td>
                    <td class="border border-gray-300 px-3 py-2">{{ $patient->phone }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $patient->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>    
</x-layouts.print>
