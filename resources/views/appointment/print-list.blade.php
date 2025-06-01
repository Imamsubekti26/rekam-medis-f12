@php
    use Carbon\Carbon;

    // Hitung akumulasi status
    $approvedCount = $appointments->where('status', 'approve')->count();
    $pendingCount = $appointments->where('status', 'pending')->count();
    $rejectedCount = $appointments->where('status', 'rejected')->count();
@endphp

<x-layouts.print>
    <h2 class="text-xl font-bold underline text-center mt-4">Daftar Janji Temu</h2>
    <p class="text-sm mt-2 mb-4 text-center border-gray-400 pb-1">
        Tanggal Cetak: {{ Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }}
    </p>

    <table class="w-full text-start mt-2 border border-gray-300 print:text-sm print:border-collapse">
        <thead class="bg-gray-100 print:bg-gray-200">
            <tr>
                <th class="border border-gray-300 px-3 py-2 text-center">No</th>
                <th class="border border-gray-300 px-3 py-2 text-center">Nama Pasien</th>
                <th class="border border-gray-300 px-3 py-2 text-center">No. Telepon</th>
                <th class="border border-gray-300 px-3 py-2 text-center">Tanggal</th>
                <th class="border border-gray-300 px-3 py-2 text-center">Waktu</th>
                <th class="border border-gray-300 px-3 py-2 text-center">Detail</th>
                <th class="border border-gray-300 px-3 py-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody class="text-center border-b-1">
            @foreach ($appointments as $appointment)
                <tr class="odd:bg-white even:bg-gray-50 print:bg-white">
                    <td class="border border-gray-300 px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $appointment->patient_name }}</td>
                    <td class="border border-gray-300 px-3 py-2">{{ $appointment->phone }}</td>
                    <td class="border border-gray-300 px-3 py-2">
                        {{ Carbon::parse($appointment->date)->translatedFormat('l, d F Y') }}
                    </td>
                    <td class="border border-gray-300 px-3 py-2">
                        {{ Carbon::parse($appointment->time)->format('H:i') }}
                    </td>
                    <td class="border border-gray-300 px-3 py-2">{{ $appointment->detail ?? '-' }}</td>
                    <td class="border border-gray-300 px-3 py-2 capitalize">{{ $appointment->status ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="text-base font-semibold mt-6 mb-2 print:mt-4">Rekapitulasi Status Janji Temu:</h3>
    <table class="w-full table-fixed text-sm border border-gray-300 print:border-collapse">
        <thead>
            <tr>
                <th class="border border-gray-300 px-3 py-2 text-center w-1/4">Approved</th>
                <th class="border border-gray-300 px-3 py-2 text-center w-1/4">Pending</th>
                <th class="border border-gray-300 px-3 py-2 text-center w-1/4">Rejected</th>
                <th class="border border-gray-300 px-3 py-2 text-center w-1/4">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border border-gray-300 px-3 py-2 text-center w-1/4">{{ $approvedCount }}</td>
                <td class="border border-gray-300 px-3 py-2 text-center w-1/4">{{ $pendingCount }}</td>
                <td class="border border-gray-300 px-3 py-2 text-center w-1/4">{{ $rejectedCount }}</td>
                <td class="border border-gray-300 px-3 py-2 text-center w-1/4">{{ $appointments->count() }}</td>
            </tr>
        </tbody>
    </table>

</x-layouts.print>
