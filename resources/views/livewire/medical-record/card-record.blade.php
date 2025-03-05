<section class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">

    {{-- Title --}}
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
        {{ __('medical_record.add') }}
    </h2>
    {{-- / Title --}}

    {{-- Form --}}
    <div class="mt-12">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3 xl:grid-cols-4 mt-12 mb-8">

            {{-- Doctor Name --}}
            @if ($doctor_list)
                <flux:select wire:model="doctor_id" label="{{ __('doctor.name') }} *" placeholder="{{ __('choose') }}">
                    @foreach ($doctor_list as $doctor )
                        <flux:select.option value="{{ $doctor->id }}">{{ $doctor->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            @else
                <flux:input wire:model="doctor_name" label="{{ __('doctor.name') }} *" readonly />
            @endif

            {{-- Temperature --}}
            <flux:input wire:model="temperature" type="number" label="{{ __('medical_record.temperature') }} (C)" />

            {{-- Weight --}}
            <flux:input wire:model="weight" type="number" label="{{ __('medical_record.weight') }} (Kg)" />

            {{-- Blood Pressure --}}
            <flux:input wire:model="blood_pressure" label="{{ __('medical_record.blood_pressure') }}" placeholder="example : 100/80" />
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-2 mt-4 mb-8">

            {{-- Anamnesis --}}
            <flux:field class="col-span-full">
                <flux:label>{{ __('medical_record.anamnesis') }} *</flux:label>
                <flux:input wire:model="anamnesis" />
                <flux:error name="anamnesis" />
            </flux:field>

            {{-- Diagnosis --}}
            <flux:textarea wire:model="diagnosis" label="{{ __('medical_record.diagnosis') }}" resize="none" />

            {{-- Therapy --}}
            <flux:textarea wire:model="therapy" label="{{ __('medical_record.therapy') }}" resize="none" />
        </div>
    </div>
    {{-- Form --}}

</section>