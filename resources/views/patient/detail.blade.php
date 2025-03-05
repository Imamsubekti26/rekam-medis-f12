@php
use Carbon\Carbon;
@endphp

<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Form Card Update --}}
        <header class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">

            {{-- Title --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                {{ __("patient.title_show") }}
            </h2>
            {{-- / Title --}}

            <form action="{{ route('patient.update', $patient->id) }}" method="POST">
                @csrf
                {{-- Form Input --}}
                <div class="grid auto-rows-min gap-4 md:grid-cols-3 mt-12 mb-8">
                    {{-- Member ID --}}
                    <flux:input label="{{ __('patient.member_id') }} *" name="member_id" value="{{ $patient->member_id }}" required />
                    {{-- Name --}}
                    <flux:input label="{{ __('patient.name') }} *" name="name" value="{{ $patient->name }}" required />
                    {{-- Address --}}
                    <flux:input label="{{ __('patient.address') }}" name="address" value="{{ $patient->address }}" />
                    {{-- Phone --}}
                    <flux:input inputmode="numeric" label="{{ __('patient.phone') }}" name="phone" value="{{ $patient->phone }}" />
                    {{-- Gender --}}
                    <flux:select label="{{ __('patient.gender') }} *" placeholder="{{ __('choose') }}" name="is_male" required>
                        <option value="1" {{ $patient->is_male ? "selected" : "" }}>{{ __('patient.male') }}</option>
                        <option value="0" {{ !$patient->is_male ? "selected" : "" }}>{{ __('patient.female') }}</option>
                    </flux:select>
                    {{-- Date of Birth --}}
                    <flux:input type="date" label="{{ __('patient.date_of_birth') }}" name="date_of_birth" value="{{ $patient->date_of_birth }}" />
                </div>
                <div class="grid auto-rows-min gap-4 md:grid-cols-2 mt-4 mb-8">
                    {{-- Drug Allergies --}}
                    <flux:textarea label="{{ __('patient.drug_allergies') }}" resize="none" name="drug_allergies">{{ $patient->drug_allergies }}</flux:textarea>
                    {{-- Food Allergies --}}
                    <flux:textarea label="{{ __('patient.food_allergies') }}" resize="none" name="food_allergies">{{ $patient->food_allergies }}</flux:textarea>
                </div>
                {{-- / Form Input --}}

                {{-- Form Action Button --}}
                <div class="flex flex-col-reverse md:flex-row justify-between gap-4">
                    <flux:modal.trigger name="delete_patient">
                        {{-- Delete Button --}}
                        <flux:button class="cursor-pointer" variant="danger">{{ __('patient.delete') }}</flux:button>
                    </flux:modal.trigger>
                    <div class="flex flex-col md:flex-row gap-4">
                        {{-- Update Button --}}
                        <flux:button class="cursor-pointer" type="submit" variant="primary" name="_method" value="PUT">{{ __('patient.update') }}</flux:button>
                        {{-- Back Button --}}
                        <flux:button href="{{ route('patient.index') }}" class="cursor-pointer" wire:navigate>{{ __('back') }}</flux:button>
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
                            <flux:button type="submit" variant="danger" name="_method" value="DELETE">{{ __('patient.delete') }}</flux:button>
                        </div>
                    </div>
                </flux:modal>
                {{-- / Modal Delete --}}
            </form>
        </header>
        {{-- / Form Card Update --}}

        {{-- Table Medical Record Lists --}}
        <section class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
            <div class="flex justify-between">
                {{-- Title --}}
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                    {{ __("patient.title_medic") }}
                </h2>
                {{-- / Title --}}
            
                {{-- Button Add New Record --}}
                <flux:button href="{{ route('record.create', ['patient_id' => $patient->id]) }}" icon="plus" wire:navigate>
                    {{ __('medical_record.add') }}</flux:button>
            </div>
            
            <table class="w-full">
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
                @if ($medical_records)
                    <tbody class="text-center">
                        @foreach ($medical_records as $record)
                            <tr>
                                <td class="p-4">{{ $record->record_number }}</td>
                                <td class="p-4">{{ Carbon::parse($record->date)->setTimezone('Asia/Jakarta')->format('y/m/d H:i') }}</td>
                                <td class="p-4">{{ $record->doctor->name }}</td>
                                <td class="p-4">{{ $record->anamnesis }}</td>
                                <td class="p-4">
                                    <flux:tooltip content="{{ __('detail') }}">
                                        <flux:button href="{{ route('record.show', $record->id) }}" icon="information-circle" size="sm"
                                            class="cursor-pointer" wire:navigate />
                                    </flux:tooltip>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </section>
        {{-- / Detail Medical Record Lists --}}
    </main>
</x-layouts.app>