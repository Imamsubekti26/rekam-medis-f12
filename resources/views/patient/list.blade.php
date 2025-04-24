@php
use Carbon\Carbon;
@endphp

<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Header --}}
        <header class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div class="p-6 md:p-8 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                <x-bread-crumbs />

                {{-- Title --}}
                <h2 class="font-semibold text-center  md:text-start text-xl text-gray-800 dark:text-gray-200 leading-tight mb-8">
                    {{ __('patient.title') }}
                </h2>
                {{-- / Title --}}

                {{-- Action Field --}}
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    {{-- Search Field --}}
                    <form class="flex gap-4 items-center">
                        <flux:input icon="magnifying-glass" placeholder="{{ __('patient.search_hint') }}" name="search"
                            value="{{ request()->query('search') }}" />
                        <input type="hidden" name="sort_by" value="{{ request()->query('sort_by') }}">
                        <flux:button type="submit" class="cursor-pointer">{{ __('patient.search') }}</flux:button>
                    </form>
                    {{-- / Search Field --}}

                    {{-- Button Filed --}}
                    <div class="flex flex-col md:flex-row gap-4">
                        {{-- Button Create --}}
                        <flux:button href="{{ route('patient.create') }}" class="cursor-pointer" icon="plus" wire:navigate>
                            {{ __('patient.title_add') }}
                        </flux:button>
                        
                        {{-- Button Print --}}
                        <flux:button
                            onclick="window.open(`{{ route('patient.print.list', [
    'search' => request()->query('search'),
    'sort_by' => request()->query('sort_by'),
]) }}`)"
                            class="cursor-pointer" icon="printer">
                            {{ __('patient.print') }}
                        </flux:button>
                    </div>
                    {{-- / Button Filed --}}

                </div>
                {{-- / Action Field --}}
            </div>
        </header>
        {{-- / Header --}}

        
        {{-- Table Patient Lists --}}
        <section
            class="w-full rounded-2xl border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-900 overflow-y-auto">
            <table class="w-full">
                <thead class="border-b-1">
                    <tr>
                        {{-- Member ID --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('patient.member_id') }}
                                <livewire:components.sorter :asc="'member_id_asc'" :desc="'member_id_desc'" />
                            </div>
                        </th>
                        {{-- Patient Name --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('patient.name') }}
                                <livewire:components.sorter :asc="'name_asc'" :desc="'name_desc'" />
                            </div>
                        </th>
                        {{-- Patient Address --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('patient.address') }}
                                <livewire:components.sorter :asc="'address_asc'" :desc="'address_desc'" />
                            </div>
                        </th>
                        {{-- Gender --}}
                        <th class="p-4 py-6">{{ __('patient.gender') }}/{{ __('patient.age') }}</th>
                        {{-- Status Rekam Medis --}}
                        <th class="p-4 py-6">{{ __('patient.medical_status') }}</th>
                        {{-- Action --}}
                        <th class="p-4 py-6">{{ __('patient.action') }}</th>
                    </tr>
                </thead>
                @if ($patients)
                    <tbody class="text-center border-b-1">
                        @foreach ($patients as $patient)
                            <tr>
                                <td class="p-4">{{ $patient->member_id }}</td>
                                <td class="p-4">{{ $patient->name }}</td>
                                <td class="p-4">{{ $patient->address }}</td>
                                <td class="p-4">{{ $patient->is_male ? 'L' : 'P' }} /
                                    {{ Carbon::createFromDate($patient->date_of_birth)->age }}</td>
                                {{-- Status Rekam Medis --}}
                                @php $count = $patient->medical_records_count; @endphp
                                <td class="p-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-medium
        {{ $count == 0 ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' }}">
                                        {{ $count == 0 ? 'Belum pernah rekam medis' : 'Rekam medis ke-' . $count }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    <flux:tooltip content="{{ __('detail') }}">
                                        <flux:button href="{{ route('patient.show', $patient->id) }}"
                                            icon="information-circle" size="sm" class="cursor-pointer"
                                            wire:navigate />
                                    </flux:tooltip>
                                    <flux:tooltip content="{{ __('medical_record.add') }}">
                                        <flux:button
                                            href="{{ route('record.create', ['patient_id' => $patient->id]) }}"
                                            icon="clipboard-document-list" size="sm" class="cursor-pointer"
                                            wire:navigate />
                                    </flux:tooltip>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
            <footer class="p-4 px-4 md:px-12">
                {{ $patients->appends(request()->query())->links() }}
            </footer>
        </section>
        {{-- / Table Patient Lists --}}

    </main>
</x-layouts.app>
