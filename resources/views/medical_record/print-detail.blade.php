@php
    use Carbon\Carbon;
@endphp
<x-layouts.print>
    <h2 class="text-xl font-bold underline text-center mt-4">Rekam Medis</h2>
    <div class="grid grid-cols-2 text-sm mt-4 mx-12">
        <div>
            <h3 class="font-bold mt-4">No. Rekam Medis:</h3>
            <p>{{ $record->patient->no_rm }}</p>
            <h3 class="font-bold mt-4">Tanggal Periksa:</h3>
            <p>{{ $record->date }}</p>
            <h3 class="font-bold mt-4">Dokter:</h3>
            <p>Dr. {{ $record->doctor->name }}</p>
        </div>
        <div>
            <h3 class="font-bold mt-4">Data Pasien:</h3>
            <table>
                <x-table-row label="No NIK">{{ $record->patient->nik }}</x-table-row>
                <x-table-row label="Nama">{{ $record->patient->name }}</x-table-row>
                <x-table-row
                    label="Jenis Kelamin">{{ $record->patient->is_male ? 'Laki-laki' : 'Perempuan' }}</x-table-row>
                <x-table-row
                    label="Umur">{{ $record->patient->date_of_birth ? Carbon::createFromDate($record->patient->date_of_birth)->age : '-' }}</x-table-row>
                <x-table-row label="Alamat">{{ $record->patient->address ?? '-' }}</x-table-row>
                <x-table-row label="Kontak">{{ $record->patient->phone ?? '-' }}</x-table-row>
            </table>
        </div>
    </div>
    <div class="text-sm mt-8 mx-12">
        <h3 class="font-bold mt-4">Hasil Pemeriksaan:</h3>
        <div class="grid grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div>
                <table class="w-full table-fixed">
                    <tr>
                        <td class="w-32 align-top font-medium">Anamnesis</td>
                        <td class="align-top">: {{ $record->anamnesis ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="w-32 align-top font-medium">Diagnosis</td>
                        <td class="align-top">: {{ $record->diagnosis ?: '-' }}</td>
                    </tr>
                </table>
            </div>

            <!-- Kolom Kanan -->
            <div>
                <table class="w-full table-fixed">
                    <tr>
                        <td class="w-32 font-medium">Suhu</td>
                        <td>: {{ $record->temperature != 0 ? $record->temperature . '°C' : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium">Weight</td>
                        <td>: {{ $record->weight != 0 ? $record->weight . ' Kg' : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium">Tekanan Darah</td>
                        <td>: {{ $record->blood_pressure ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @if (count($record->prescriptions) > 0)
        <div class="text-sm mt-8 mx-12 print:mx-12 print:mt-4">
            <h3 class="font-bold mt-4 text-lg border-b border-gray-400 pb-1 print:font-semibold print:text-base">
                Resep Obat
            </h3>
            <table class="w-full text-start mt-3 border border-gray-300 print:text-sm print:border-collapse">
                <thead class="bg-gray-100 print:bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-3 py-2 text-left w-[35%]">Nama Obat</th>
                        <th class="border border-gray-300 px-3 py-2 text-left w-[15%]">Aturan Pakai</th>
                        <th class="border border-gray-300 px-3 py-2 text-left w-[20%]">Waktu Minum</th>
                        <th class="border border-gray-300 px-3 py-2 text-left w-[30%]">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($record->prescriptions as $p)
                        <tr class="odd:bg-white even:bg-gray-50 print:bg-white">
                            <td class="border border-gray-300 px-3 py-2">{{ $p->medicine->name }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $p->rule_of_use }}</td>
                            <td class="border border-gray-300 px-3 py-2">
                                {{ $p->aftermeal ? 'Setelah Makan' : 'Sebelum Makan' }}
                            </td>
                            <td class="border border-gray-300 px-3 py-2">{{ $p->notes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-sm mt-8 mx-12 print:mx-12 print:mt-4">
            <h3 class="font-bold mt-4 text-lg border-b border-gray-400 pb-1 print:font-semibold print:text-base">
                Resep Obat
            </h3>
            <div
                class="bg-yellow-100 text-yellow-800 border border-yellow-300 px-4 py-3 rounded relative mt-4 print:bg-white print:text-black print:border-0">
                <strong>Perhatian:</strong> Tidak ada resep obat yang tercatat untuk kunjungan ini.
            </div>
        </div>
    @endif

</x-layouts.print>
