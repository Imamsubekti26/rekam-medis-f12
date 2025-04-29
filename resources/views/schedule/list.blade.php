@php
use Carbon\Carbon;
@endphp

<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        {{-- Alert for Required Data --}}
        <div>
            <div
                class="rounded-xl border border-yellow-300 bg-yellow-100 text-yellow-800 dark:border-yellow-600 dark:bg-yellow-900 dark:text-yellow-200 opacity-70 p-4 text-sm">
                <p><strong class="font-semibold">Perhatian:</strong> Isi jadwal anda minimal untuk 1 minggu kedepan, karena kami membutuhkannya untuk layanan janji temu.</p>
            </div>
        </div>
        {{-- / Alert for Required Data --}}

        {{-- Header --}}
        <header class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div
                class="p-6 md:p-8 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex justify-between items-start">
                    <x-bread-crumbs />
                    <img src="{{ asset('/assets/img/redesignf21m.png') }}" alt="Logo"
                        class="w-18 sm:w-25 h-auto object-contain" />
                </div>

                <h2
                    class="font-semibold text-xl text-center md:text-start text-gray-800 dark:text-gray-200 leading-tight mb-8">
                    Jadwal Dokter
                </h2>

                <div class="flex flex-col md:flex-row justify-between gap-4">
                    {{-- Search Field --}}
                    <form class="flex gap-4 items-center">
                        <flux:input icon="magnifying-glass" placeholder="{{ __('doctor.search_hint') }}" name="search"
                            value="{{ request()->query('search') }}" />
                        <input type="hidden" name="sort_by" value="{{ request()->query('sort_by') }}">
                        <flux:button type="submit" class="cursor-pointer">{{ __('doctor.search') }}</flux:button>
                    </form>
                    <flux:button href="{{ route('schedule.create') }}"
                        class="cursor-pointer !bg-custom-2 hover:!bg-blue-400 !text-white dark:!bg-custom-50 dark:hover:!bg-purple-600"
                        icon="plus" wire:navigate>
                        Tambah Jadwal
                    </flux:button>
                </div>
            </div>
        </header>

        {{-- Table Doctor Schedule --}}
        <section
            class="w-full rounded-2xl border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-900 overflow-y-auto">
            <table class="w-full">
                <thead class="border-b-1">
                    <tr>
                        <th class="p-4 py-6">No</th>
                        <th class="p-4 py-6">Dokter</th>
                        <th class="p-4 py-6">Tanggal</th>
                        <th class="p-4 py-6">Waktu Mulai</th>
                        <th class="p-4 py-6">Waktu Selesai</th>
                        <th class="p-4 py-6">Durasi Pasien</th>
                        <th class="p-4 py-6">{{ __('action') }}</th>
                    </tr>
                </thead>

                @if ($schedules->isEmpty())
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center pt-8 text-gray-800 dark:text-gray-200">
                                {{ __('No schedules available.') }}
                            </td>
                        </tr>
                    </tbody>
                @else
                    <tbody class="text-center border-b-1">
                        @foreach ($schedules as $schedule)
                            <tr
                                class="hover:bg-blue-100 dark:hover:bg-slate-700 transition even:bg-blue-50 dark:even:bg-slate-800">
                                <td class="p-4">{{ $loop->iteration }}</td>
                                <td class="p-4">{{ $schedule->doctor->name ?? '-' }}</td>
                                <td class="p-4">
                                    {{ \Carbon\Carbon::parse($schedule->available_date)->translatedFormat('l, d F Y') }}
                                </td>
                                <td class="p-4">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                </td>
                                <td class="p-4">
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </td>
                                <td class="p-4">
                                    {{ $schedule->per_patient_time }} menit
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center items-center gap-1">
                                        <flux:tooltip content="{{ __('Edit') }}">
                                            <flux:button href="{{ route('schedule.show', $schedule->id) }}"
                                                icon="pencil" size="sm"
                                                class="cursor-pointer !bg-yellow-400 hover:!bg-yellow-500 !text-white"
                                                wire:navigate />
                                        </flux:tooltip>

                                        {{-- Delete Button with Tooltip --}}
                                        <flux:tooltip content="{{ __('Delete') }}">
                                            <flux:modal.trigger name="delete_schedule">
                                                <flux:button icon="trash" size="sm"
                                                    class="cursor-pointer !bg-red-500 hover:!bg-red-600 !text-white" />
                                            </flux:modal.trigger>
                                        </flux:tooltip>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
            {{-- Modal Delete --}}
            <flux:modal name="delete_schedule" class="md:w-96">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{ __('schedule.delete') }}</flux:heading>
                        <flux:subheading>{{ __('schedule.delete_msg') }}</flux:subheading>
                    </div>
                    @if (!empty($schedule))
                        <form method="POST" action="{{ route('schedule.destroy', $schedule->id) }}"
                            class="flex justify-end">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="danger">{{ __('schedule.delete') }}
                            </flux:button>
                        </form>
                    @endif

                </div>
            </flux:modal>
            {{-- / Modal Delete --}}

            {{-- Pagination --}}
            <footer class="p-4 px-4 md:px-12">
                {{ $schedules->links() }}
            </footer>
        </section>

    </main>
</x-layouts.app>
