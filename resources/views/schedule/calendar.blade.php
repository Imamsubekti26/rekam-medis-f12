<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<style>
    @media (max-width: 768px) {

        /* Ukuran teks title kalender */
        .fc-center h2 {
            font-size: 1rem !important;
            margin-top: 10px
        }

        /* Ukuran tombol navigasi dan teks header */
        .fc-button {
            font-size: 0.75rem !important;
            padding: 4px 6px !important;
        }

        /* Tombol di kiri/kanan kalender (prev/next/today) */
        .fc-header-left,
        .fc-header-right {
            font-size: 0.75rem !important;
        }

        /* Container kalender agar tidak kepotong di mobile */
        #calendar {
            font-size: 0.8rem;
        }

        .fc-toolbar {
            padding: 4px 8px;
        }

    }
</style>


<x-layouts.app>
    <!-- Modal -->
    <div id="tailwindModal" class="fixed inset-0 z-10 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen p-4 bg-black/50 bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 w-full max-w-2xl">
                <h2 class="text-2xl font-semibold mb-6 text-black dark:text-white text-center">Detail Jadwal</h2>
                <!-- Dynamic content goes here -->
                <div id="scheduleDetails" class="text-black dark:text-white overflow-x-auto">
                    <table class="w-full text-left table-auto border-collapse">
                        <tbody>
                            <tr>
                                <th class="py-2 px-4 font-medium border-b border-gray-300 dark:border-gray-700">Dokter
                                </th>
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700">
                                    <span id="doctorName"></span>
                                </td>
                            </tr>
                            <tr>
                                <th class="py-2 px-4 font-medium border-b border-gray-300 dark:border-gray-700">Tanggal
                                    Tersedia</th>
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700">
                                    <span id="availableDate"></span>
                                </td>
                            </tr>
                            <tr>
                                <th class="py-2 px-4 font-medium border-b border-gray-300 dark:border-gray-700">Waktu
                                    Mulai</th>
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700">
                                    <span id="startTime"></span>
                                </td>
                            </tr>
                            <tr>
                                <th class="py-2 px-4 font-medium border-b border-gray-300 dark:border-gray-700">Waktu
                                    Selesai</th>
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700">
                                    <span id="endTime"></span>
                                </td>
                            </tr>
                            <tr>
                                <th class="py-2 px-4 font-medium border-b border-gray-300 dark:border-gray-700">Waktu
                                    Per Pasien</th>
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700">
                                    <span id="perPatientTime"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 flex justify-end">
                    <button id="closeModal"
                        class="px-5 py-2 cursor-pointer bg-red-500 text-white rounded hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="mt-3 lg:flex lg:gap-8">
        <div id="calendar" class="lg:w-2/3 w-full bg-white dark:bg-zinc-800/50 p-5 rounded-2xl"></div>
        <div class="mt-8 lg:mt-0 lg:w-1/3">

            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Jadwal Dokter Hari Ini</h3>
            @php
                $today = \Carbon\Carbon::now()->toDateString();
                $todaySchedules = $events->filter(function ($event) use ($today) {
                    return $event['available_date'] === $today;
                });
            @endphp

            @if ($todaySchedules->isEmpty())
                <div
                    class="p-4 bg-yellow-100 text-yellow-800 rounded-lg dark:bg-yellow-800 dark:text-yellow-100 shadow-sm">
                    Tidak ada jadwal dokter untuk hari ini.
                </div>
            @else
                <div class="grid gap-6 ">
                    @foreach ($todaySchedules as $schedule)
                        <div
                            class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-5 shadow-md hover:shadow-lg transition-shadow duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-lg font-bold text-zinc-800 dark:text-white">
                                    {{ $schedule['doctor_name'] }}
                                </h4>
                                <span
                                    class="inline-block px-2 py-1 text-xs font-medium text-white rounded bg-custom-2 dark:bg-custom-50">
                                    Hari Ini
                                </span>
                            </div>
                            <div class="text-sm text-zinc-600 dark:text-zinc-300 space-y-1">
                                <p><span class="font-medium">Waktu:</span> {{ $schedule['start_time'] }} -
                                    {{ $schedule['end_time'] }}</p>
                                <p><span class="font-medium">Durasi per pasien:</span>
                                    {{ $schedule['handle_count'] }} menit</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div> <!-- penutup div dalam card jadwal -->
    </div> <!-- penutup flex container -->
    
    
</x-layouts.app>

<script>
    const schedule = @json($events);

    function smoothScrollTo(id) {
        const element = document.getElementById(id);
        if ('scrollBehavior' in document.documentElement.style) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            window.scrollTo(0, element.offsetTop);
        }
    }

    function applyEventStyle(info) {
        const isDarkMode = document.documentElement.classList.contains('dark');
        const bgColor = isDarkMode ? '#8b5cf6' : '#3b82f6';
        const borderColor = isDarkMode ? '#7c3aed' : '#2563eb';

        info.el.style.backgroundColor = bgColor;
        info.el.style.borderColor = borderColor;
        info.el.style.color = 'white';
        info.el.style.padding = '4px 6px';
        info.el.style.borderRadius = '4px';
        info.el.style.cursor = 'pointer';
    }

    function loadCalendar() {
        const calendarEl = document.getElementById('calendar');
        if (!calendarEl) return;

        const { Calendar, dayGridPlugin, timeGridPlugin, interactionPlugin } = window.FullCalendar;

        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            aspectRatio: 1.4,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay' // You can add more views if needed
            },
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari'
            },
            events: schedule,
            displayEventTime: false,
            eventDidMount: function(info) {
                applyEventStyle(info);
            },
            dateClick: function(info) {
                $wire.getDaySchedules(info);
                smoothScrollTo('schedule');
            },
            eventClick: function({ event }) {
                // Tampilkan modal dengan informasi event
                document.getElementById('doctorName').textContent = event.extendedProps.doctor_name;
                document.getElementById('availableDate').textContent = event.extendedProps.available_date;
                document.getElementById('startTime').textContent = event.extendedProps.start_time;
                document.getElementById('endTime').textContent = event.extendedProps.end_time;
                document.getElementById('perPatientTime').textContent = event.extendedProps.handle_count;
                document.getElementById('tailwindModal').classList.remove('hidden');
            }
        });

        calendar.render();

        // Observer untuk dark mode
        if (window.calendarDarkModeObserver) window.calendarDarkModeObserver.disconnect();
        window.calendarDarkModeObserver = new MutationObserver((mutations) => {
            for (const mutation of mutations) {
                if (mutation.attributeName === "class") {
                    calendar.destroy();
                    loadCalendar(); // Re-init saat mode gelap terang berubah
                }
            }
        });
        window.calendarDarkModeObserver.observe(document.documentElement, {
            attributes: true
        });
    }

    // Modal close
    document.getElementById('closeModal')?.addEventListener('click', function () {
        document.getElementById('tailwindModal')?.classList.add('hidden');
    });
    

    // Inisialisasi saat halaman dimuat
    window.addEventListener('DOMContentLoaded', () => {
        if (window.location.pathname.includes('calendar')) {
            loadCalendar();
        }
    });
</script>

