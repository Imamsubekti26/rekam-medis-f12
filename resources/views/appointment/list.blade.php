@php
use Carbon\Carbon;
@endphp

<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
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
                    {{ __('appointment.title') }}
                </h2>

                <div class="flex flex-col md:flex-row justify-between gap-4">
                    {{-- Search Field --}}
                    <form class="flex gap-4 items-center">
                        <flux:input icon="magnifying-glass" placeholder="{{ __('appointment.search_hint') }}"
                            name="search" value="{{ request()->query('search') }}" />
                        <input type="hidden" name="sort_by" value="{{ request()->query('sort_by') }}">
                        <flux:button type="submit" class="cursor-pointer">{{ __('appointment.search') }}</flux:button>
                    </form>
                    <div class="flex flex-col md:flex-row gap-4">
                        <flux:button href="{{ route('schedule.calendar') }}"
                            class="cursor-pointer !bg-custom-2 hover:!bg-blue-400 !text-white dark:!bg-custom-50 dark:hover:!bg-purple-600"
                            icon="plus" wire:navigate>
                            {{ __('appointment.add') }}
                        </flux:button>
                        {{-- / Search Field --}}
                        <flux:button
                            onclick="window.open(`{{ route('appointment.print.list', [
                                'search' => request()->query('search'),
                                'sort_by' => request()->query('sort_by'),
                            ]) }}`)"
                            class="cursor-pointer !bg-slate-500 hover:!bg-slate-400 !text-white dark:!bg-zinc-700 dark:hover:!bg-zinc-600"
                            icon="printer">
                            {{ __('appointment.print') }}
                        </flux:button>
                    </div>
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
                        <th class="p-4 py-6">Nama Pasien</th>
                        <th class="p-4 py-6">Nomor WA</th>
                        <th class="p-4 py-6">Tanggal</th>
                        <th class="p-4 py-6">Waktu</th>
                        <th class="p-4 py-6">Dokter</th>
                        <th class="p-4 py-6">Status</th>
                        <th class="p-4 py-6">{{ __('action') }}</th>
                    </tr>
                </thead>

                @if ($appointments->isEmpty())
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center pt-8 text-gray-800 dark:text-gray-200">
                                {{ __('appointment.empty_list') }}
                            </td>
                        </tr>
                    </tbody>
                @else
                    <tbody class="text-center border-b-1">
                        @foreach ($appointments as $appointment)
                            <tr
                                class="hover:bg-blue-100 dark:hover:bg-slate-700 transition even:bg-blue-50 dark:even:bg-slate-800">
                                <td class="p-4">{{ $loop->iteration }}</td>
                                <td class="p-4">{{ $appointment->patient->name ?? '-' }}</td>
                                <td class="p-4">{{ $appointment->phone ?? '-' }}</td>
                                <td class="p-4">
                                    {{ Carbon::parse($appointment->date)->translatedFormat('l, d F Y') }}
                                </td>
                                <td class="p-4">
                                    {{ Carbon::parse($appointment->time)->format('H:i') }}
                                </td>
                                <td class="p-4">
                                    {{ $appointment->doctor->name }}
                                </td>
                                <td class="p-4">
                                    <flux:badge
                                        color="{{ $appointment->status === 'pending' ? 'orange' : ($appointment->status === 'approved' ? 'green' : 'red') }}">
                                        {{ $appointment->status }}</flux:badge>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center items-center gap-1">
                                        @if ($appointment->status === 'pending' && request()->user()->is_editor)
                                            {{-- Approve Button with Tooltip --}}
                                            <flux:modal.trigger name="approve_appointment#{{ $loop->iteration }}">
                                                <flux:tooltip content="{{ __('appointment.approve') }}">
                                                    <flux:button icon="check-circle" size="sm"
                                                        class="cursor-pointer !bg-green-400 hover:!bg-green-500 !text-white" />
                                                </flux:tooltip>
                                            </flux:modal.trigger>

                                            {{-- Reject Button with Tooltip --}}
                                            <flux:modal.trigger name="reject_appointment#{{ $loop->iteration }}">
                                                <flux:tooltip content="{{ __('appointment.reject') }}">
                                                    <flux:button icon="x-circle" size="sm"
                                                        class="cursor-pointer !bg-red-500 hover:!bg-red-600 !text-white" />
                                                </flux:tooltip>
                                            </flux:modal.trigger>

                                            {{-- Edit Button --}}
                                            <flux:tooltip content="{{ __('appointment.update') }}">
                                                <flux:button href="{{ route('appointment.edit', $appointment->id) }}"
                                                    icon="pencil" size="sm"
                                                    class="cursor-pointer !bg-yellow-500 hover:!bg-yellow-600 !text-white"
                                                    wire:navigate />
                                            </flux:tooltip>
                                        @elseif ($appointment->status === 'rejected' && request()->user()->is_editor)
                                            {{-- Reschedule Button with Tooltip --}}
                                            <flux:tooltip content="{{ __('appointment.reschedule') }}">
                                                <flux:button href="{{ route('appointment.edit', $appointment->id) }}"
                                                    icon="clock" size="sm"
                                                    class="cursor-pointer !bg-yellow-500 hover:!bg-yellow-600 !text-white"
                                                    wire:navigate />
                                            </flux:tooltip>
                                        @elseif ($appointment->status === 'approved' && request()->user()->is_editor)
                                            {{-- Call Button with Tooltip --}}
                                            <flux:tooltip content="{{ __('appointment.chat') }}">
                                                <flux:button
                                                    href="https://wa.me/{{ toWhatsappNumber($appointment->phone) }}/"
                                                    target="_blank" icon="chat-bubble-oval-left-ellipsis" size="sm"
                                                    class="cursor-pointer !bg-green-500 hover:!bg-green-600 !text-white" />
                                            </flux:tooltip>

                                            {{-- Reschedule Button with Tooltip --}}
                                            <flux:tooltip content="{{ __('appointment.reschedule') }}">
                                                <flux:button href="{{ route('appointment.edit', $appointment->id) }}"
                                                    icon="clock" size="sm"
                                                    class="cursor-pointer !bg-yellow-500 hover:!bg-yellow-600 !text-white"
                                                    wire:navigate />
                                            </flux:tooltip>
                                        @endif

                                        @if ($appointment->status === 'approved' && (request()->user()->role == 'doctor' || request()->user()->is_admin))
                                            {{-- Process Button with Tooltip --}}
                                            <flux:tooltip content="{{ __('appointment.process') }}">
                                                <flux:button href="{{ route('record.create', ['patient_id' => $appointment->patient_id]) }}"
                                                    icon="clipboard-document-list" size="sm"
                                                    class="cursor-pointer !bg-blue-500 hover:!bg-blue-600 !text-white"
                                                    wire:navigate />
                                            </flux:tooltip>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal Approve --}}
                            <flux:modal name="approve_appointment#{{ $loop->iteration }}" class="md:w-96">
                                <div class="mb-6">
                                    <flux:heading size="lg">{{ __('appointment.approve_title') }}</flux:heading>
                                    <flux:subheading>{{ __('appointment.approve_msg') }}</flux:subheading>
                                </div>
                                @if (!empty($appointment))
                                    <livewire:components.appointment-whatsapp-confirm type="approve"
                                        :appointment="$appointment" />
                                @endif
                            </flux:modal>
                            {{-- / Modal Approve --}}

                            {{-- Modal Delete --}}
                            <flux:modal name="reject_appointment#{{ $loop->iteration }}" class="md:w-96">
                                <div>
                                    <div class="mb-6">
                                        <flux:heading size="lg">{{ __('appointment.delete') }}</flux:heading>
                                        <flux:subheading>{{ __('appointment.delete_msg') }}</flux:subheading>
                                    </div>
                                    @if (!empty($appointment))
                                        <livewire:components.appointment-whatsapp-confirm type="reject"
                                            :appointment="$appointment" />
                                    @endif
                                </div>
                            </flux:modal>
                            {{-- / Modal Delete --}}
                        @endforeach
                    </tbody>
                @endif
            </table>

            {{-- Pagination --}}
            <footer class="p-4 px-4 md:px-12">
                {{ $appointments->links() }}
            </footer>
        </section>

    </main>
</x-layouts.app>
