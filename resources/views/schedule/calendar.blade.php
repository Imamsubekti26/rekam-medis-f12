<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

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


    <div id="calendar"></div>
</x-layouts.app>

<script>
    function loadCalendar() {
        const schedule = @json($events);

        const calendarEl = document.getElementById('calendar');
        if (!calendarEl) return; // Jangan lanjut kalau #calendar belum ada

        // Destroy kalau sebelumnya sudah ada
        if ($('#calendar').data('fullCalendar')) {
            $('#calendar').fullCalendar('destroy');
        }

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari'
            },
            events: schedule,
            selectable: true,
            selectHelper: true,
            timeFormat: 'HH:mm',
            eventClick: function(event) {
                $('#doctorName').text(event.doctor_name);
                $('#availableDate').text(event.available_date);
                $('#startTime').text(event.start_time);
                $('#endTime').text(event.end_time);
                $('#perPatientTime').text(event.per_patient_time);
                $('#tailwindModal').removeClass('hidden');
            },
            eventRender: function(event, element) {
                element.css('cursor', 'pointer');
                applyEventStyle(element);
            }
        });
    }

    function applyEventStyle(element) {
        const isDarkMode = document.documentElement.classList.contains('dark');
        if (isDarkMode) {
            element.css({
                'background-color': '#8b5cf6',
                'border-color': '#7c3aed',
                'color': 'white',
                'padding': '4px 6px',
                'border-radius': '4px'
            });
        } else {
            element.css({
                'background-color': '#3b82f6',
                'border-color': '#2563eb',
                'color': 'white',
                'padding': '4px 6px',
                'border-radius': '4px'
            });
        }
    }

    // Modal close event
    document.getElementById('closeModal')?.addEventListener('click', function() {
        document.getElementById('tailwindModal')?.classList.add('hidden');
    });

    // Observer untuk mendeteksi dark/light mode
    if (window.calendarDarkModeObserver) window.calendarDarkModeObserver.disconnect();
    window.calendarDarkModeObserver = new MutationObserver((mutations) => {
        for (const mutation of mutations) {
            if (mutation.attributeName === "class") {
                loadCalendar(); // Reload calendar saat dark/light mode berubah
            }
        }
    });
    window.calendarDarkModeObserver.observe(document.documentElement, { attributes: true });

    // Load pertama kali
    window.addEventListener('DOMContentLoaded', () => {
        if (window.location.pathname.includes('calendar')) {
            loadCalendar();
        }
    });
</script>




