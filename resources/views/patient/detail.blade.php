@php
use Carbon\Carbon;
@endphp

<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Form Card Update --}}
        <header
            class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">

            {{-- Title --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                {{ __('patient.title_show') }}
            </h2>
            {{-- / Title --}}

            <form action="{{ route('patient.update', $patient->id) }}" method="POST">
                @csrf
                {{-- Form Input --}}
                <div class="grid auto-rows-min gap-4 md:grid-cols-3 mt-12 mb-8">
                    {{-- Member ID --}}
                    <flux:input label="{{ __('patient.nik') }} *" name="nik" value="{{ $patient->nik }}" required />
                    {{-- Name --}}
                    <flux:input label="{{ __('patient.name') }} *" name="name" value="{{ $patient->name }}"
                        required />
                    {{-- Address --}}
                    <flux:input label="{{ __('patient.address') }}" name="address" value="{{ $patient->address }}" />
                    {{-- Phone --}}
                    <flux:input inputmode="numeric" label="{{ __('patient.phone') }}" name="phone"
                        value="{{ $patient->phone }}" />
                    {{-- Gender --}}
                    <flux:select label="{{ __('patient.gender') }} *" placeholder="{{ __('choose') }}" name="is_male"
                        required>
                        <option value="1" {{ $patient->is_male ? 'selected' : '' }}>{{ __('patient.male') }}
                        </option>
                        <option value="0" {{ !$patient->is_male ? 'selected' : '' }}>{{ __('patient.female') }}
                        </option>
                    </flux:select>
                    {{-- Date of Birth --}}
                    <flux:input type="date" label="{{ __('patient.date_of_birth') }}" name="date_of_birth"
                        value="{{ Carbon::parse($patient->date_of_birth)->format('Y-m-d') }}" />
                </div>
                <div class="grid auto-rows-min gap-4 md:grid-cols-2 mt-4 mb-8">
                    {{-- Drug Allergies --}}
                    <flux:textarea label="{{ __('patient.drug_allergies') }}" resize="none" name="drug_allergies">
                        {{ $patient->drug_allergies }}</flux:textarea>
                    {{-- Food Allergies --}}
                    <flux:textarea label="{{ __('patient.food_allergies') }}" resize="none" name="food_allergies">
                        {{ $patient->food_allergies }}</flux:textarea>
                </div>
                {{-- / Form Input --}}

                {{-- Form Action Button --}}
                <div class="flex flex-col-reverse md:flex-row justify-between gap-4">
                    <flux:modal.trigger name="delete_patient">
                        {{-- Delete Button --}}
                        @if (request()->user()->is_editor)
                            <flux:button class="cursor-pointer" variant="danger">{{ __('patient.delete') }}
                            </flux:button>
                        @endif
                    </flux:modal.trigger>
                    <div class="flex flex-col md:flex-row gap-4">
                        {{-- Update Button --}}
                        @if (request()->user()->is_editor)
                            <flux:button class="cursor-pointer" type="submit" variant="primary" name="_method"
                                value="PUT">{{ __('patient.update') }}</flux:button>
                        @endif
                        {{-- Back Button --}}
                        <flux:button href="{{ route('patient.index') }}" class="cursor-pointer" wire:navigate>
                            {{ __('back') }}</flux:button>
                    </div>
                </div>
                {{-- / Form Action Button --}}

                {{-- Modal Delete --}}
                <flux:modal name="delete_patient" class="md:w-96">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">{{ __('patient.delete') }}</flux:heading>
                            <flux:subheading>{{ __('patient.delete_msg') }}</flux:subheading>
                        </div>
                        <div class="flex justify-end">
                            <flux:button type="submit" variant="danger" name="_method" value="DELETE">
                                {{ __('patient.delete') }}</flux:button>
                        </div>
                    </div>
                </flux:modal>
                {{-- / Modal Delete --}}
            </form>
        </header>
        {{-- / Form Card Update --}}

        {{-- Table Medical Record Lists --}}
        <section
            class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
                {{-- Title --}}
                <h2
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center md:text-left">
                    {{ __('patient.title_medic') }}
                </h2>
                {{-- / Title --}}

                {{-- Button Group --}}
                <div class="flex flex-col sm:flex-row gap-2 justify-center md:justify-end">
                    {{-- Add New Record Button --}}
                    <flux:button href="{{ route('record.create', ['patient_id' => $patient->id]) }}" variant="primary"
                        icon="plus" wire:navigate>
                        {{ __('medical_record.add') }}
                    </flux:button>

                    {{-- Print Button --}}
                    <flux:button
                        onclick="window.open(`{{ route('record.print.by_patient', ['patient' => $patient->id]) }}`)"
                        class="cursor-pointer !bg-slate-500 hover:!bg-slate-400 !text-white dark:!bg-zinc-700 dark:hover:!bg-zinc-600"
                        icon="printer">
                        {{ __('medical_record.print_rm') }}
                    </flux:button>
                </div>
            </div>

            <div class="w-full mt-8 overflow-y-auto">
                @if (count($medical_records) != 0)
                    <table class="w-full min-w-2xl">
                        <thead class="border-b-1">
                            <tr>
                                {{-- Record Number --}}
                                <th class="p-4 py-6">{{ __('medical_record.record_number') }}</th>
                                {{-- Date --}}
                                <th class="p-4 py-6">{{ __('medical_record.date') }}</th>
                                {{-- Doctor Name --}}
                                <th class="p-4 py-6">{{ __('doctor.name') }}</th>
                                {{-- Anamnesis --}}
                                <th class="p-4 py-6">{{ __('medical_record.anamnesis') }}</th>
                                {{-- Action --}}
                                <th class="p-4 py-6">{{ __('patient.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($medical_records as $record)
                                <tr>
                                    <td class="p-4">{{ $record->patient->no_rm }}</td>
                                    <td class="p-4">
                                        {{ Carbon::parse($record->date)->format('y/m/d H:i') }}
                                    </td>
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
                    </table>
                @else
                    <div class="w-full h-full flex justify-center items-center py-5">
                        <p class="italic">{{ __('patient.empty_medical_record') }}</p>
                    </div>
                @endif
            </div>
        </section>
        {{-- / Detail Medical Record Lists --}}
        {{-- Button Print --}}
        <section
            class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-6 md:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                {{-- Attention Section --}}
                <div
                    class="text-sm text-yellow-800 dark:text-yellow-200 bg-yellow-100 dark:bg-yellow-800 border border-yellow-300 dark:border-yellow-600 px-4 py-2 rounded-md shadow-sm w-full md:w-auto">
                    <span class="font-semibold">Perhatian:</span> Silakan cetak riwayat medis pasien untuk
                    keperluan dokumentasi atau rujukan.
                </div>

                {{-- Back to Patient List Button --}}
                <flux:button href="{{ route('patient.index') }}"
                    class="!bg-slate-500 hover:!bg-slate-400 !text-white dark:!bg-zinc-700 dark:hover:!bg-zinc-600"
                    icon="arrow-left">
                    List Pasien
                </flux:button>
            </div>
        </section>



    </main>
</x-layouts.app>
