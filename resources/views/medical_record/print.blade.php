@php
use Carbon\Carbon;
@endphp
<x-layouts.print>
    <main class="">
        <div class="border h-20">
            <h1 class="text-2xl text-center font-bold">Kop Surat</h1>
        </div>
        <div class="dividers"></div>
        <h2 class="text-xl font-bold underline text-center mt-4">Rekam Medis</h2>
        <div class="grid grid-cols-2 text-sm mt-4">
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
                    <x-table-row label="Jenis Kelamin">{{ $record->patient->is_male ? 'Laki-laki' : 'Perempuan' }}</x-table-row>
                    <x-table-row label="Umur">{{ $record->patient->date_of_birth ? Carbon::createFromDate($record->patient->date_of_birth)->age : '-' }}</x-table-row>
                    <x-table-row label="Alamat">{{ $record->patient->address ?? '-' }}</x-table-row>                    
                    <x-table-row label="Kontak">{{ $record->patient->phone ?? '-' }}</x-table-row>
                </table>
            </div>
        </div>
        <div class="text-sm mt-8">
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
                        <x-table-row label="Suhu">{{ $record->temperature != 0 ? $record->temperature . 'c' : '-' }}</x-table-row>
                        <x-table-row label="Weight">{{ $record->weight != 0 ? $record->weight . 'Kg' : '-' }}</x-table-row>
                        <x-table-row label="Tekanan Darah">{{ $record->blood_pressure ?? '-' }}</x-table-row>
                    </table>
                </div>
            </div>
        </div>
        @if (count($record->prescriptions) > 0)
            <div class="text-sm mt-8">
                <h3 class="font-bold mt-4">Resep:</h3>
                <table class="w-full text-start">
                    @foreach ($record->prescriptions as $p)
                        <tr>
                            <td width="35%">{{ $p->medicine->name }}</td>
                            <td width="15%">{{ $p->rule_of_use }}</td>
                            <td width="20%">{{ $p->aftermeal ? 'setelah makan' : 'sebelum makan' }}</td>
                            <td width="30%">{{ $p->notes }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </main>
</x-layouts.print>