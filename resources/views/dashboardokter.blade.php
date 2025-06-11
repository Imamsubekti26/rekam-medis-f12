<style>
    /* Sembunyikan panah di layar kecil */
    @media (max-width: 767px) {
        .fa-arrow-right {
            display: none !important;
        }
    }
</style>
<x-layouts.app>
    <div
        class="flex w-full flex-1 flex-col rounded-2xl px-8 py-6 bg-gradient-to-br from-blue-100 via-blue-100 to-blue-200 dark:from-slate-900 dark:via-slate-900 dark:to-slate-900 shadow-xl">

        <div class="flex justify-between items-start">
            {{-- Breadcrumbs kiri --}}
            <x-bread-crumbs />

            {{-- Logo kanan --}}
            <img src="{{ asset('/assets/img/redesignf21m.png') }}" alt="Logo"
                class="w-18 sm:w-25 !important h-auto object-contain" />
        </div>

        {{-- Title --}}
        <h2 class="font-semibold text-center md:text-start text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
            {{ __('dashboard.welcome') }}
            <span class="text-rose-600 dark:text-fuchsia-300 font-bold">
                Dr. {{ Auth::user()->name }}
            </span>!
        </h2>

        {{-- / Title --}}

        <p class="text-sm text-rose-600 dark:text-rose-300">
            Jika tampilan terlihat berantakan, silakan lakukan <strong>zoom out</strong> pada browser Anda (Ctrl +
            Scroll atau Ctrl + -).
        </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
        <!-- Kolom Kiri: 2/3 lebar -->
        <div class="md:col-span-2 flex flex-col gap-4">
            <!-- Jadwal Janji Temu Hari Ini -->
            <div class="flex w-full flex-1 flex-col rounded-xl p-6 bg-zinc-50 dark:bg-gray-900 shadow-xl">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Jadwal Janji Temu Hari Ini</h3>
                @if ($appointments->isEmpty())
                    <div
                        class="flex flex-col items-center justify-center p-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl text-blue-800 dark:text-blue-300 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-3 text-blue-400 dark:text-blue-300"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M6.75 2a.75.75 0 0 1 .75.75V4h9V2.75a.75.75 0 0 1 1.5 0V4h.75A2.25 2.25 0 0 1 21 6.25v13.5A2.25 2.25 0 0 1 18.75 22H5.25A2.25 2.25 0 0 1 3 19.75V6.25A2.25 2.25 0 0 1 5.25 4H6V2.75A.75.75 0 0 1 6.75 2zM6 5.5H5.25a.75.75 0 0 0-.75.75v1.5h15V6.25a.75.75 0 0 0-.75-.75H18V5.5h-1.5v1.25a.75.75 0 0 1-1.5 0V5.5h-6v1.25a.75.75 0 0 1-1.5 0V5.5H6zM4.5 9v10.75c0 .414.336.75.75.75h13.5a.75.75 0 0 0 .75-.75V9h-15z" />
                        </svg>
                        <p class="text-lg font-semibold">Belum ada janji temu dari pasien</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Silakan buat jadwal praktik dan tunggu hingga pasien membuat janji temu.</p>
                    </div>
                @else
                    <table
                        class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded">
                        <thead>
                            <tr class="text-left bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <th class="px-4 py-2">Nama Pasien</th>
                                <th class="px-4 py-2">Waktu Janji Temu</th>
                                <th class="px-4 py-2">Keluhan Utama</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr class="border-t border-gray-300 dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $appointment->patient->name }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                    </td>
                                    <td class="px-4 py-2">{{ $appointment->detail }}</td>
                                    <td class="px-4 py-2 capitalize">
                                        <flux:badge
                                            color="{{ $appointment->status === 'pending' ? 'orange' : ($appointment->status === 'approved' ? 'green' : 'red') }}">
                                            {{ $appointment->status }}</flux:badge>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Riwayat Pemeriksaan Terkini -->
            <div class="flex w-full flex-1 flex-col rounded-xl p-6 bg-zinc-50 dark:bg-gray-900 shadow-xl">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Riwayat Pemeriksaan Terkini</h3>
                @if ($recentRecords->isEmpty())
                    <div
                        class="flex flex-col items-center justify-center p-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-xl text-yellow-800 dark:text-yellow-300 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-10 h-10 mb-3 text-yellow-400 dark:text-yellow-300" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12 22c5.421 0 10-4.579 10-10S17.421 2 12 2 2 6.579 2 12s4.579 10 10 10zm0-1.5A8.5 8.5 0 1 1 12 3.5a8.5 8.5 0 0 1 0 17zm0-6a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm1-6.25c0-.414-.336-.75-.75-.75h-1.5a.75.75 0 0 0 0 1.5h.75v3.25a.75.75 0 0 0 1.5 0V8.25z" />
                        </svg>
                        <p class="text-lg font-semibold">Belum ada riwayat pemeriksaan</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Silakan tambah data rekam medis untuk
                            melihat riwayat di sini.</p>
                    </div>
                @else
                    <table
                        class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded">
                        <thead>
                            <tr class="text-left bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <th class="px-4 py-2">Nama Pasien</th>
                                <th class="px-4 py-2">Diagnosa Singkat</th>
                                <th class="px-4 py-2">Tanggal Pemeriksaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentRecords as $record)
                                <tr class="border-t border-gray-300 dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $record->patient->name }}</td>
                                    <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit($record->diagnosis, 50) }}
                                    </td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($record->date)->format('d-m-Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: 1/3 lebar -->
        <div class="flex flex-col gap-4">
            <!-- Jadwal Dokter -->
            <div class="bg-white dark:bg-gray-900 rounded shadow p-4">
                <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 rounded px-3 py-2 mb-3">
                    <i class="fas fa-calendar-alt text-xl text-indigo-500"></i>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-100 text-right">Jadwal Dokter</h4>
                </div>
                <ul class="text-gray-800 dark:text-gray-100 text-sm space-y-1">
                    @forelse ($doctorSchedules as $schedule)
                        <li class="flex justify-between">
                            <div>
                                <div>
                                    {{ \Carbon\Carbon::parse($schedule->available_date)->translatedFormat('l, d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ substr($schedule->start_time, 0, 5) }} -
                                    {{ substr($schedule->end_time, 0, 5) }} |
                                    {{ ucfirst($schedule->schedule_type) }}
                                </div>
                            </div>
                            <strong class="text-sm">{{ $schedule->appointments_count }} Pasien</strong>

                        </li>
                    @empty
                        <li class="text-gray-500 dark:text-gray-400 text-center">Belum ada jadwal</li>
                    @endforelse
                </ul>
            </div>
            <!-- Pasien Diperiksa -->
            <div class="bg-white dark:bg-gray-900 rounded shadow p-4">
                <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 rounded px-3 py-2 mb-3">
                    <i class="fas fa-user-md text-xl text-green-500"></i>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-100 text-right">Pasien Diperiksa</h4>
                </div>
                <ul class="text-gray-800 dark:text-gray-100 text-sm space-y-1">
                    <li class="flex justify-between">
                        <span>Hari Ini</span>
                        <strong>{{ $patientsExaminedToday }}</strong>
                    </li>
                    <li class="flex justify-between">
                        <span>Minggu Ini</span>
                        <strong>{{ $patientsExaminedThisWeek }}</strong>
                    </li>
                    <li class="flex justify-between">
                        <span>Bulan Ini</span>
                        <strong>{{ $patientsExaminedThisMonth }}</strong>
                    </li>
                </ul>
            </div>


            <!-- Janji Temu Terjadwal -->
            <div class="bg-white dark:bg-gray-900 rounded shadow p-4">
                <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 rounded px-3 py-2 mb-3">
                    <i class="fas fa-calendar-check text-xl text-yellow-500"></i>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-100 text-right">Janji Temu Terjadwal
                    </h4>
                </div>
                <ul class="text-gray-800 dark:text-gray-100 text-sm space-y-1">
                    <li class="flex justify-between">
                        <span>Hari Ini</span>
                        <strong>{{ $appointmentsToday }}</strong>
                    </li>
                    <li class="flex justify-between">
                        <span>Minggu Ini</span>
                        <strong>{{ $appointmentsThisWeek }}</strong>
                    </li>
                    <li class="text-gray-500 dark:text-gray-400 font-medium mt-2">Status Hari Ini:</li>
                    <li class="flex justify-between ml-2">
                        <span>✅ Appoved</span>
                        <span>{{ $appointmentStatusCounts['approved'] ?? 0 }}</span>
                    </li>
                    <li class="flex justify-between ml-2">
                        <span>⏳ Pending</span>
                        <span>{{ $appointmentStatusCounts['pending'] ?? 0 }}</span>
                    </li>
                    <li class="flex justify-between ml-2">
                        <span>❌ Rejected</span>
                        <span>{{ $appointmentStatusCounts['rejected'] ?? 0 }}</span>
                    </li>
                </ul>
            </div>



        </div>
    </div>

</x-layouts.app>
