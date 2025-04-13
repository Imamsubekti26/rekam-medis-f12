@php
    use Carbon\Carbon;
@endphp
<style>
    @media print {
        html {
            color-scheme: light;
            /* Force light mode */
            --tw-bg-opacity: 1;
            background-color: white !important;
        }

        body {
            background-color: white !important;
            color: black !important;
        }

        .dark * {
            background-color: white !important;
            color: black !important;
        }
    }
</style>
<x-layouts.print>
    <main class="">
        <table style="width: 100%; border-bottom: 4px solid #000000;">
            <tr>
                <td style="width: 15%; border: none;">
                    <img src="/build/assets/img/logof21warna.png" alt="Logo Apotek F-21 Minomartani"
                        style="width: 100px; height: auto; margin: 10px;">
                </td>
                <td style="text-align: center; border: none;">
                    <h2 style="margin: 0; font-size: 1.5rem; font-weight: 800;">Klinik F-21 Minomartani</h2>
                    <p style="margin: 0; font-size: 12px;">Jl. Contoh Alamat No. 456, Minomartani, Sleman, Yogyakarta</p>
                    <p style="margin: 0; font-size: 12px;">Telepon: (0274) 7654321 | Email: info@apotekf21.com</p>
                </td>
                <td style="width: 15%; border: none;">
                </td>
            </tr>
        </table>


        <div class="dividers"></div>
        <h2 class="text-xl font-bold underline text-center mt-4">Rekam Medis</h2>
        <div class="grid grid-cols-2 text-sm mt-4 mx-12">
            <div>
                <h3 class="font-bold mt-4">No. Rekam Medis:</h3>
                <p>{{ $record->record_number }}</p>
                <h3 class="font-bold mt-4">Tanggal Periksa:</h3>
                <p>{{ $record->date }}</p>
                <h3 class="font-bold mt-4">Dokter:</h3>
                <p>{{ $record->doctor->name }}</p>
            </div>
            <div>
                <h3 class="font-bold mt-4">Data Pasien:</h3>
                <table>
                    <x-table-row label="ID Member">{{ $record->patient->member_id }}</x-table-row>
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
            <div class="grid grid-cols-2">
                <div>
                    <table>
                        <x-table-row label="Anamnesis">{{ $record->anamnesis }}</x-table-row>
                        <x-table-row label="Diagnosis">{{ $record->diagnosis }}</x-table-row>
                    </table>
                </div>
                <div>
                    <table>
                        <x-table-row
                            label="Suhu">{{ $record->temperature != 0 ? $record->temperature . 'c' : '-' }}</x-table-row>
                        <x-table-row
                            label="Weight">{{ $record->weight != 0 ? $record->weight . 'Kg' : '-' }}</x-table-row>
                        <x-table-row label="Tekanan Darah">{{ $record->blood_pressure ?? '-' }}</x-table-row>
                    </table>
                </div>
            </div>
        </div>
        @if (count($record->prescriptions) > 0)
            <div class="text-sm mt-8 mx-12 print:mx-12 print:mt-4">
                <h3 class="font-bold mt-4 text-lg border-b border-gray-400 pb-1 print:font-semibold print:text-base">
                    Resep Obat</h3>
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
                                    {{ $p->aftermeal ? 'Setelah Makan' : 'Sebelum Makan' }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $p->notes }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </main>
</x-layouts.print>
