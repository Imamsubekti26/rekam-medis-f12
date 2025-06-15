@php
    use Carbon\Carbon;
@endphp

<x-layouts.print>
    <h2 class="text-xl font-bold underline text-center mt-4">Laporan Rekam Medis Pasien</h2>

    {{-- Informasi Pasien --}}
    <div class="grid grid-cols-2 text-sm mt-4 mx-12">
        <div>
            <h3 class="font-bold mt-2">No. Rekam Medis:</h3>
            <p>{{ $patient->no_rm }}</p>
            <h3 class="font-bold mt-2">Nama:</h3>
            <p>{{ $patient->name }}</p>
            <h3 class="font-bold mt-2">Jenis Kelamin:</h3>
            <p>{{ $patient->is_male ? 'Laki-laki' : 'Perempuan' }}</p>
        </div>
        <div>
            <h3 class="font-bold mt-2">NIK:</h3>
            <p>{{ $patient->nik }}</p>
            <h3 class="font-bold mt-2">Umur:</h3>
            <p>{{ $patient->date_of_birth ? Carbon::createFromDate($patient->date_of_birth)->age . ' tahun' : '-' }}</p>
            <h3 class="font-bold mt-2">Alamat:</h3>
            <p>{{ $patient->address ?? '-' }}</p>
            <h3 class="font-bold mt-2">Kontak:</h3>
            <p>{{ $patient->phone ?? '-' }}</p>
        </div>
    </div>

    {{-- Tabel Rekam Medis --}}
    <div class="text-sm mt-8 mx-12 print:mt-6 print:mx-12">
        <h3 class="font-bold text-lg border-b border-gray-400 pb-1">Riwayat Pemeriksaan</h3>
        <table class="w-full mt-3 border border-gray-300 print:text-sm print:border-collapse">
            <thead class="bg-gray-100 print:bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-3 py-2 text-left w-[5%]">No</th>
                    <th class="border border-gray-300 px-3 py-2 text-left w-[20%]">Tanggal</th>
                    <th class="border border-gray-300 px-3 py-2 text-left w-[20%]">Dokter</th>
                    <th class="border border-gray-300 px-3 py-2 text-left">Anamnesis</th>
                    <th class="border border-gray-300 px-3 py-2 text-left">Diagnosa</th>
                </tr>
            </thead>
            <tbody>
                @if ($medical_records->isEmpty())
                    <tr>
                        <td colspan="5" class="border border-gray-300 px-3 py-4 text-center text-red-600 italic">
                            Tidak ada data rekam medis untuk pasien ini.
                        </td>
                    </tr>
                @else
                    @foreach ($medical_records as $record)
                        <tr class="odd:bg-white even:bg-gray-50 print:bg-white">
                            <td class="border border-gray-300 px-3 py-2">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 px-3 py-2">
                                {{ Carbon::parse($record->date)->format('d/m/Y H:i') }}</td>
                            <td class="border border-gray-300 px-3 py-2">Dr. {{ $record->doctor->name }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $record->anamnesis }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $record->diagnosis }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>

        </table>
    </div>
</x-layouts.print>
