@php
    use Carbon\Carbon;
@endphp
<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Header --}}
        <header class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div
                class="flex flex-col md:flex-row items-center justify-between gap-4 p-6 md:p-12 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                {{-- Title Page --}}
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                    {{ __('medical_record.title') }}
                </h2>
                {{-- / Title Page --}}

                {{-- Action Field --}}
                <div class="flex flex-col gap-4">
                    {{-- Button Create --}}
                    <flux:button href="{{ route('record.create') }}" class="cursor-pointer" icon="plus" wire:navigate>
                        {{ __('medical_record.title_add') }}</flux:button>

                    {{-- Button Print --}}
                    <flux:button onclick="printTable()" class="cursor-pointer" icon="printer">
                        {{ __('medical_record.print') }}</flux:button>

                </div>
                {{-- / Action Field --}}
            </div>

        </header>
        {{-- / Header --}}
        {{-- Filter Search Card --}}
        <section
    class="rounded-xl border border-blue-300 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/30 px-4 py-4 sm:px-6 md:px-12 md:py-6 transition-all duration-300">
    <form class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between w-full flex-wrap" method="GET">
        
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center w-full md:w-auto flex-wrap">
            {{-- Search Input --}}
            <flux:input 
                icon="magnifying-glass" 
                placeholder="{{ __('medical_record.search_hint') }}"
                name="search" 
                value="{{ request()->query('search') }}" 
                class="w-full sm:w-64" 
            />

            {{-- Rentang Tanggal --}}
            <div class="flex flex-wrap items-center gap-2">
                <label for="date_start" class="text-sm text-zinc-700 dark:text-zinc-200 whitespace-nowrap">
                    {{ __('medical_record.date') }}
                </label>
                <input 
                    type="date" 
                    id="date_start" 
                    name="date_start" 
                    value="{{ request('date_start') }}"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 p-2 text-sm w-full sm:w-auto" 
                />
                <span class="text-zinc-600 dark:text-zinc-300">s/d</span>
                <input 
                    type="date" 
                    name="date_end" 
                    value="{{ request('date_end') }}"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 p-2 text-sm w-full sm:w-auto" 
                />
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
            class="w-full rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 overflow-y-auto">
            <table class="w-full">
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
                        <th class="p-4 py-6 text-center">{{ __('action') }}</th>
                    </tr>
                </thead>
                @if ($records)
                    <tbody class="text-center border-b-1">
                        @foreach ($records as $record)
                            <tr>
                                <td class="p-4">{{ $record->record_number }}</td>
                                <td class="p-4">
                                    {{ Carbon::parse($record->date)->setTimezone('Asia/Jakarta')->format('y/m/d H:i') }}
                                </td>
                                <td class="p-4">{{ $record->patient->name }}</td>
                                <td class="p-4">{{ $record->doctor->name }}</td>
                                <td class="p-4">{{ $record->anamnesis }}</td>
                                <td class="p-4">
                                    <flux:tooltip content="{{ __('detail') }}">
                                        <flux:button href="{{ route('record.show', $record->id) }}"
                                            icon="information-circle" size="sm" class="cursor-pointer"
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

        <script>
            function printTable() {
                var printContent = document.getElementById("printableTable").innerHTML;
                var originalContent = document.body.innerHTML;
                document.body.innerHTML = printContent;
                window.print();
                document.body.innerHTML = originalContent;
                location.reload();
            }
        </script>

    </main>
</x-layouts.app>
