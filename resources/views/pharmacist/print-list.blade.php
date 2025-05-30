@php
use Carbon\Carbon;
@endphp

<x-layouts.print>
    <h2 class="text-xl font-bold underline text-center mt-4">Daftar Dokter</h2>
    <p class="text-sm mt-2 mb-4 text-center border-gray-400 pb-1">
        Tanggal Cetak: {{ Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }} 
    </p>
    
    
    <table class="w-full text-start mt-2 border border-gray-300 print:text-sm print:border-collapse">
        <thead class="bg-gray-100 print:bg-gray-200">
            <tr>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('pharmacist.id') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('pharmacist.name') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('email') }}
                    </div>
                </th>
                <th class="border border-gray-300 px-3 py-2 text-left">
                    <div class="flex justify-center items-center gap-2">
                        {{ __('pharmacist.phone') }}
                    </div>
                </th>
            </tr>
        </thead>
        <tbody class="text-center border-b-1">
            @foreach ($pharmacists as $pharmacist)
                <tr class="odd:bg-white even:bg-gray-50 print:bg-white">
                    <td class="border border-gray-300 px-3 py-2">{{ $pharmacist->id }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $pharmacist->name }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $pharmacist->email }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $pharmacist->phone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.print>
