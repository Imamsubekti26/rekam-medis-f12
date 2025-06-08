@php
    use \Carbon\Carbon;
@endphp

<form class="mt-12" wire:submit.prevent="submit">
    @csrf
    {{-- Form Input --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Patient NIK --}}
        <flux:input wire:model="patientNIK" label="{{ __('appointment.nik') }} *" name="patientNIK"
            :disabled="$appointmentId" required />
        {{-- Dokter --}}
        @if ($doctor_use_select && !$appointmentId)
            <flux:select wire:model="doctor_id" label="{{ __('doctor.name') }}" placeholder="Choose doctor..."
                name="doctor_id" wire:change="getSchedules" required>
                @foreach ($doctorList as $doctor)
                    <flux:select.option value="{{ $doctor->id }}">{{ $doctor->name }}</flux:select.option>
                @endforeach
            </flux:select>
        @else
            <div>
                <flux:input wire:model="doctor_name" label="{{ __('doctor.name') }} *" disabled />
                <input type="hidden" wire:model="doctor_id" name="doctor_id">
            </div>
        @endif
        {{-- Patient Name --}}
        <flux:input wire:model="patientName" label="{{ __('appointment.name') }} *" name="patientName"
            :disabled="$appointmentId" required />
        {{-- Phone --}}
        <flux:input wire:model="phone" label="{{ __('appointment.phone') }} *" placeholder="0852..." name="phone"
            :disabled="$appointmentId" required />
        {{-- Date --}}
        <flux:input type="date" wire:model="selectedDate" wire:change="getSchedules"
            label="{{ __('appointment.date') }} *" name="date" min="{{ Carbon::today()->format('Y-m-d') }}"
            :disabled="$disableDate" required />

        {{-- TIme --}}
        @if($disableTime)
            <flux:input type="time" label="{{ __('appointment.time') }} *" name="time" disabled />
        @elseif (!$isRandomVisibility)
            <flux:select wire:model="selectedTime" label="{{ __('appointment.time') }} *" placeholder="Choose time..."
                name="time" required>
                @foreach ($availableTime as $time)
                    <flux:select.option value="{{ $time }}">{{ $time }}</flux:select.option>
                @endforeach
            </flux:select>
        @else
            <flux:input wire:model="selectedTime" type="time" label="{{ __('appointment.time') }} *" name="time"
                min="{{ Carbon::parse($schedule->start_time)->format('H:i') ?? '00:00' }}"
                max="{{ Carbon::parse($schedule->end_time)->format('H:i') ?? '23:59' }}" required />
        @endif

        {{-- Detail --}}
        <div class="col-span-1 md:col-span-2">
            <flux:textarea wire:model="detail" label="{{ __('appointment.detail') }} *" resize="none" name="detail"
                required />
        </div>
    </div>
    {{-- / Form Input --}}

    {{-- Note--}}
    <p class="italic mt-4 text-red-500">Note: {{ __('appointment.create_msg') }}.</p>
    {{-- / Note --}}

    {{-- Action Button Form --}}
    <div class="flex flex-col md:flex-row justify-end gap-4 mt-8">
        @if(request()->user())
            {{-- Submit Button --}}
            <flux:button type="submit" variant='primary' class="cursor-pointer">
                {{ $appointmentId ? __('appointment.update') : __('appointment.add') }}
            </flux:button>
            {{-- Cancel Button --}}
            <flux:button class="cursor-pointer" href="{{ route('appointment.index') }}" wire:navigate> {{ __('cancel') }}
            </flux:button>
        @else
            {{-- Submit Button for unauthorize user --}}
            <flux:modal.trigger name="submit_warning">
                <flux:button type="button" variant='primary' class="cursor-pointer"> {{ __('appointment.add') }}
                </flux:button>
            </flux:modal.trigger>
        @endif

    </div>
    {{-- / Action Button Form --}}

    {{-- Modal Submit --}}
    <flux:modal name="submit_warning" class="md:w-96">
        @if($hasSubmitted)
            <div class="space-y-6">
                <flux:heading size="lg">{{ __('Permintaan Terkirim') }}</flux:heading>
                <div class="flex gap-4">
                    <flux:icon.check-badge class="size-12 text-green-500" />
                    <flux:text>Permintaan janji temu dengan dokter telah terkirim. silakan tunggu konfirmasi dari admin kami
                        melalui Whatsapp</flux:text>
                </div>
                <div class="flex justify-end">
                    <flux:button href="{{ route('home') }}" variant="primary">{{ __('understand') }}</flux:button>
                </div>
            </div>
        @else
            <div class="space-y-6">
                <flux:heading size="lg">{{ __('Nomor Whatsapp Wajib Aktif') }}</flux:heading>
                <div class="flex gap-4">
                    <flux:icon.exclamation-triangle class="size-12 text-orange-500" />
                    <flux:text>{{ __('appointment.create_msg') }}</flux:text>
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary">{{ __('send') }}</flux:button>
                </div>
            </div>
        @endif
    </flux:modal>
    {{-- / Modal Submit --}}
</form>