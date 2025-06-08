@php
use \Carbon\Carbon;
@endphp

<div class="w-full">
    <div class="flex flex-col md:flex-row gap-4">
        {{-- Kalender --}}
        <div wire:ignore id="calendar" class="w-full md:w-1/2 bg-zinc-50 dark:bg-zinc-900 p-4 rounded-lg"></div>

        {{-- Daftar Jadwal --}}
        <div id="schedule" class="w-full md:w-1/2 overflow-y-auto">
            <div class="mb-8 mt-8 md:mt-0">
                <h2 class="font-bold text-center">Jadwal yang Tersedia untuk</h2>
                <h1 class="text-xl font-bold text-center">{{ Carbon::parse($today)->translatedFormat('j F Y') }}
                </h1>
                <h3 class="text-sm text-center">(klik pada kalender untuk melihat jadwal pada tanggal lain)</h3>
            </div>
            @if (count($selectedSchedule) == 0)
                <div class="text-center bg-amber-300 dark:bg-amber-800 p-4 rounded">tidak ada jadwal tersedia untuk tanggal
                    {{ Carbon::parse($today)->translatedFormat('j F Y') }}
                </div>
            @endif
            <div class="grid w-full grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($selectedSchedule as $schedule)
                    <div class="p-4 rounded-lg border dark:border-zinc-600 bg-zinc-50 dark:bg-zinc-900" wire:ignore>
                        <div class="flex justify-between">
                            <div class="flex flex-col justify-between">
                                <h1 class="font-semibold text-lg first-letter:uppercase">{{ $schedule->doctor->name }}</h1>
                                <p class="text-sm">
                                    {{  Carbon::parse($schedule->start_time)->format('H:i') }} -
                                    {{  Carbon::parse($schedule->end_time)->format('H:i') }}</p>
                                </div>
                                <div class="flex flex-col items-end gap-4">
                                    <p class="text-sm">{{ $schedule->appointments_count }} pendaftar </p>
                                <flux:modal.trigger name="register">
                                    <flux:button wire:click="showModalDialog('{{ $schedule->id }}')"
                                        class="cursor-pointer !bg-custom-2 hover:!bg-blue-400 !text-white dark:!bg-custom-50 dark:hover:!bg-purple-600">
                                        Jadwalkan
                                    </flux:button>
                                </flux:modal.trigger>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Modal buat janji temu --}}
        <flux:modal name="register" class="bg-zinc-50 dark:bg-zinc-900">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                {{ __('appointment.title_add') }}
            </h2>
            {{ $selectedDoctor['id'] }}
            <livewire:components.appointment-form />
        </flux:modal>
    </div>
</div>


@script
<script>
    const schedule = @json($events);

    function smoothScrollTo(id) {
        const element = document.getElementById(id);
        if ('scrollBehavior' in document.documentElement.style) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' }); // Browser mendukung smooth scroll
        } else {
            window.scrollTo(0, element.offsetTop); // Fallback untuk browser lama
        }
    }

    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const { Calendar, dayGridPlugin, interactionPlugin } = window.FullCalendar;

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        height: 525,
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },
        events: schedule,
        displayEventTime: false,
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            day: 'Hari'
        },
        dateClick: function (info) {
            $wire.getDaySchedules(info);
            smoothScrollTo('schedule')
        },
        eventClick: function ({ event }) {
            Flux.modal('register').show()
            $wire.showModalDialog(event.id)
        }
    });

    calendar.render();

</script>
@endscript