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
                    {{-- Breadcrumbs kiri --}}
                    <x-bread-crumbs />

                    {{-- Logo kanan --}}
                    <img src="{{ asset('/assets/img/redesignf21m.png') }}" alt="Logo"
                        class="w-18 sm:w-25 !important h-auto object-contain" />
                </div>

                {{-- Title --}}
                <h2
                    class="font-semibold text-xl text-center md:text-start text-gray-800 dark:text-gray-200 leading-tight mb-8">
                    {{ __('medical_record.title') }}
                </h2>
                {{-- / Title --}}

                {{-- Action Field --}}
                <div class="flex flex-col md:flex-row justify-end gap-4">
                    {{-- Button Create --}}
                    {{-- Button Add --}}
                    @if (request()->user()->is_editor)
                        <flux:button href="{{ route('record.create') }}"
                            class="cursor-pointer !bg-custom-2 hover:!bg-blue-400 !text-white dark:!bg-custom-50 dark:hover:!bg-purple-600"
                            icon="plus" wire:navigate>
                            {{ __('medical_record.title_add') }}
                        </flux:button>
                    @endif

                    {{-- Button Print --}}
                    <flux:button
                        onclick="window.open(`{{ route('record.print.list', [
                            'date_start' => request()->query('date_start'),
                            'date_end' => request()->query('date_end'),
                        ]) }}`)"
                        class="cursor-pointer !bg-slate-500 hover:!bg-slate-400 !text-white dark:!bg-zinc-700 dark:hover:!bg-zinc-600"
                        icon="printer">
                        {{ __('medical_record.print') }}
                    </flux:button>


                </div>
                {{-- / Action Field --}}
            </div>

        </header>
        {{-- / Header --}}
        {{-- Filter Search Card --}}
        <section
            class="rounded-xl border border-blue-500 dark:border-custom-50 bg-blue-300/30 dark:bg-custom-50/30 px-6 py-8 md:px-8 md:py-6 transition-all duration-300">
            <form class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between w-full flex-wrap"
                method="GET">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center w-full md:w-auto flex-wrap">
                    {{-- Search Input --}}
                    <flux:input icon="magnifying-glass" placeholder="{{ __('medical_record.search_hint') }}"
                        name="search" value="{{ request()->query('search') }}" class="w-full sm:w-64" />

                    {{-- Rentang Tanggal --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <label for="date_start" class="text-sm text-zinc-700 dark:text-zinc-200 whitespace-nowrap">
                            {{ __('medical_record.date') }}
                        </label>
                        <flux:input type="date" name="date_start" value="{{ request()->query('date_start') }}"
                            class="rounded-lg text-sm w-full sm:w-auto" />
                        <label for="date_start" class="text-sm text-zinc-700 dark:text-zinc-200 whitespace-nowrap">
                            {{ __('s/d') }}
                        </label>
                        <flux:input type="date" name="date_end" value="{{ request()->query('date_end') }}"
                            class="rounded-lg text-sm w-full sm:w-auto" />
                    </div>
                </div>

                {{-- Submit Filter Button --}}
                <div class="flex gap-2 flex-wrap">
                    <input type="hidden" name="sort_by" value="{{ request()->query('sort_by') }}">
                    <flux:button type="submit" icon="magnifying-glass" class="cursor-pointer">
                        {{ __('medical_record.search') }}
                    </flux:button>
                    <flux:button type="button" onclick="window.location='{{ route('record.index') }}'" variant="ghost"
                        class="cursor-pointer">
                        Reset
                    </flux:button>
                </div>
            </form>
        </section>


        {{-- / Filter Search Card --}}


        {{-- Table Patient Lists --}}
        <section id="printableTable"
            class="w-full rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 overflow-x-auto">
            <table class="min-w-[1000px] w-full">
                <thead class="border-b-1">
                    <tr>
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('medical_record.record_number') }}
                                <livewire:components.sorter :asc="'record_number_asc'" :desc="'record_number_desc'" />
                            </div>
                        </th>
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('medical_record.date') }}
                                <livewire:components.sorter :asc="'date_asc'" :desc="'date_desc'" />
                            </div>
                        </th>
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('patient.name') }}
                            </div>
                        </th>
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('doctor.name') }}
                            </div>
                        </th>
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('medical_record.anamnesis') }}
                            </div>
                        </th>
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('medical_record.prescription_status') }}
                            </div>
                        </th>
                        <th class="p-4 py-6 text-center">{{ __('action') }}</th>
                    </tr>
                </thead>
                @if ($records)
                    <tbody class="text-center border-b-1">
                        @foreach ($records as $record)
                            <tr
                                class="hover:bg-blue-100 dark:hover:bg-slate-700 transition even:bg-blue-50 dark:even:bg-slate-800">
                                <td class="p-4">{{ $record->patient->no_rm }}</td>
                                <td class="p-4">
                                    {{ Carbon::parse($record->date)->setTimezone('Asia/Jakarta')->format('y/m/d H:i') }}
                                </td>
                                <td class="p-4">{{ $record->patient->name }}</td>
                                <td class="p-4">{{ $record->doctor->name }}</td>
                                <td class="p-4">{{ $record->anamnesis }}</td>
                                <td class="p-4">
                                    @if ($record->prescriptions && $record->prescriptions->count() > 0)
                                        <span
                                            class="bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 text-xs font-semibold px-3 py-1.5 rounded-full">
                                            {{ __('Sudah diisi') }}
                                        </span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 text-xs font-semibold px-3 py-1.5 rounded-full">
                                            {{ __('Belum diisi') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <flux:tooltip content="{{ __('detail') }}">
                                        <flux:button href="{{ route('record.show', $record->id) }}"
                                            icon="information-circle" size="sm"
                                            class="cursor-pointer !bg-custom-2 !text-white dark:!bg-yellow-500 dark:hover:!bg-yellow-400 transition duration-200 ease-in-out rounded-md shadow"
                                            wire:navigate />

                                    </flux:tooltip>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
            <footer class="p-4 px-4 md:px-12">
                {{ $records->appends(request()->query())->links() }}
            </footer>
        </section>
        {{-- / Table Patient Lists --}}

    </main>
</x-layouts.app>
