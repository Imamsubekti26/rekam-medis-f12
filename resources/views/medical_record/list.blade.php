@php
use Carbon\Carbon;
@endphp
<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Header --}}
        <header class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 p-6 md:p-12 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                {{-- Title Page --}}
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                    {{ __("medical_record.title") }}
                </h2>
                {{-- / Title Page --}}

                {{-- Action Field --}}
                <div class="flex flex-col gap-4">
                    {{-- Button Create --}}
                    <flux:button href="{{ route('record.create') }}" class="cursor-pointer" icon="plus" wire:navigate>{{ __('medical_record.title_add') }}</flux:button>
                    
                    {{-- Button Print --}}
                    <flux:button onclick="printTable()" class="cursor-pointer" icon="printer">{{ __('medical_record.print') }}</flux:button>
                    
                    {{-- Search Field --}}
                    <form class="flex gap-4 items-center">
                        <flux:input icon="magnifying-glass" placeholder="{{ __('medical_record.search_hint') }}" name="search" value="{{ request()->query('search') }}" />
                        <input type="hidden" name="sort_by" value="{{ request()->query('sort_by') }}">
                        <flux:button type="submit" class="cursor-pointer">{{ __('medical_record.search') }}</flux:button>
                    </form>
                    {{-- / Search Field --}}

                </div>
                {{-- / Action Field --}}
            </div>
        </header>
        {{-- / Header --}}

        {{-- Table Patient Lists --}}
        <section id="printableTable" class="w-full rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 overflow-y-auto">
            <table class="w-full">
                <thead class="border-b-1">
                    <tr>
                        <th class="p-4 py-6">{{ __('medical_record.record_number') }}</th>
                        <th class="p-4 py-6">{{ __('medical_record.date') }}</th>
                        <th class="p-4 py-6">{{ __('patient.name') }}</th>
                        <th class="p-4 py-6">{{ __('doctor.name') }}</th>
                        <th class="p-4 py-6">{{ __('medical_record.anamnesis') }}</th>
                    </tr>
                </thead>
                @if ($records)
                    <tbody class="text-center">
                        @foreach ($records as $record)
                            <tr>
                                <td class="p-4">{{ $record->record_number }}</td>
                                <td class="p-4">{{ Carbon::parse($record->date)->setTimezone('Asia/Jakarta')->format('y/m/d H:i') }}</td>
                                <td class="p-4">{{ $record->patient->name }}</td>
                                <td class="p-4">{{ $record->doctor->name }}</td>
                                <td class="p-4">{{ $record->anamnesis }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
            <footer class="p-4 px-4 md:px-12 border-t-1">
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
