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
                    class="font-semibold text-center  md:text-start text-xl text-gray-800 dark:text-gray-200 leading-tight mb-8">
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
                        @if (request()->user()->is_editor)
                            <flux:button href="{{ route('patient.create') }}"
                                class="cursor-pointer !bg-custom-2 hover:!bg-blue-400 !text-white dark:!bg-custom-50 dark:hover:!bg-purple-600"
                                icon="plus" wire:navigate>
                                {{ __('patient.title_add') }}
                            </flux:button>
                        @endif

                        {{-- Button Print --}}
                        <flux:button
                            onclick="window.open(`{{ route('patient.print.list', [
                                'search' => request()->query('search'),
                                'sort_by' => request()->query('sort_by'),
                            ]) }}`)"
                            class="cursor-pointer !bg-slate-500 hover:!bg-slate-400 !text-white dark:!bg-zinc-700 dark:hover:!bg-zinc-600"
                            icon="printer">
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
            <table class="w-full min-w-[1000px]">
                <thead class="border-b-1">
                    <tr>
                        {{-- NIK --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('patient.nik') }}
                                <livewire:components.sorter :asc="'nik_asc'" :desc="'nik_desc'" />
                            </div>
                        </th>
                        {{-- no_rm --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('patient.no_rm') }}
                                <livewire:components.sorter :asc="'no_rm_asc'" :desc="'no_rm_desc'" />
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
                            <tr
                                class="hover:bg-blue-100 dark:hover:bg-slate-700 transition even:bg-blue-50 dark:even:bg-slate-800">
                                <td class="p-4">{{ $patient->nik }}</td>
                                <td class="p-4">{{ $patient->no_rm }}</td>
                                <td class="p-4">{{ $patient->name }}</td>
                                <td
                                    class="p-4 {{ empty($patient->address) ? 'italic text-red-500 dark:text-red-400' : '' }}">
                                    {{ $patient->address ?: 'Belum diisi' }}
                                </td>
                                <td class="p-4">{{ $patient->is_male ? 'L' : 'P' }} /
                                    {{ Carbon::createFromDate($patient->date_of_birth)->age }}</td>
                                {{-- Status Rekam Medis --}}
                                @php $count = $patient->medical_records_count; @endphp
                                <td class="p-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-medium
                                        {{ $count == 0
                                            ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'
                                            : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' }}">
                                        {{ $count == 0 ? 'Belum pernah rekam medis' : 'Rekam medis ke-' . $count }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    <flux:tooltip content="{{ __('detail') }}">
                                        <flux:button href="{{ route('patient.show', $patient->id) }}"
                                            icon="information-circle" size="sm"
                                            class="cursor-pointer !bg-custom-2 !text-white dark:!bg-yellow-500 dark:hover:!bg-yellow-400"
                                            wire:navigate />
                                    </flux:tooltip>
                                    @if (request()->user()->is_editor)
                                        <flux:tooltip content="{{ __('medical_record.add') }}">
                                            <flux:button
                                                href="{{ route('record.create', ['patient_id' => $patient->id]) }}"
                                                icon="clipboard-document-list" size="sm"
                                                class="cursor-pointer !bg-emerald-500 hover:!bg-emerald-600 !text-white dark:!bg-emerald-600 dark:hover:!bg-emerald-500"
                                                wire:navigate />
                                        </flux:tooltip>
                                    @endif
                                    {{-- Print Rekam Medis Pasien --}}
                                    <flux:tooltip content="{{ __('medical_record.print_rm') }}">
                                        <flux:button
                                            onclick="window.open(`{{ route('record.print.by_patient', ['patient' => $patient->id]) }}`)"
                                            icon="printer" size="sm"
                                            class="cursor-pointer !bg-slate-500 hover:!bg-slate-400 !text-white dark:!bg-zinc-700 dark:hover:!bg-zinc-600" />
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
