{{-- Form Card --}}
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div
        class="border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
            {{ __("appointment.title_add") }}
        </h2>
        <form class="mt-12" action="{{ route('appointment.store') }}" wire:submit.prevent="submit" method="POST">
            @csrf
            {{-- Form Input --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Patient Name --}}
                <flux:input wire:model="patientName" label="{{ __('appointment.name') }} *" name="patientName" required />
                {{-- Phone --}}
                <flux:input wire:model="phone" label="{{ __('appointment.phone') }} *" placeholder="0852..." name="phone" required />
                {{-- Date --}}
                <flux:input 
                    type="date"
                    wire:model="selectedDate" 
                    wire:change="getSchedules"
                    label="{{ __('appointment.date') }} *" 
                    name="date"
                    required 
                />

                {{-- TIme --}}
                @if($disableTime)
                <flux:input type="time" label="{{ __('appointment.time') }} *" name="time" disabled />
                @elseif (count($availableTime) > 0)
                    <flux:select wire:model="selectedTime" label="{{ __('appointment.time') }}" placeholder="Choose time..." name="time" required>
                        @foreach ($availableTime as $time)
                            <flux:select.option value="{{ $time }}">{{ $time }}</flux:select.option>
                        @endforeach
                    </flux:select>
                @else
                <flux:input wire:model="selectedTime" type="time" label="{{ __('appointment.time') }} *" name="time" required />
                @endif

                {{-- Detail --}}
                <div class="col-span-1 md:col-span-2">
                    <flux:textarea wire:model="detail" label="{{ __('appointment.detail') }} *" resize="none" name="detail" required />
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
                    <flux:button type="submit" variant='primary' class="cursor-pointer"> {{ __('appointment.add') }} </flux:button>
                    {{-- Cancel Button --}}
                    <flux:button class="cursor-pointer" href="{{ route('appointment.index') }}" wire:navigate> {{ __('cancel') }} </flux:button>
                @else
                    {{-- Submit Button for unauthorize user --}}
                    <flux:modal.trigger name="submit_warning" >
                        <flux:button type="button" variant='primary' class="cursor-pointer"> {{ __('appointment.add') }} </flux:button>
                    </flux:modal.trigger>
                @endif
                
            </div>
            {{-- / Action Button Form --}}

            {{-- Modal Submit --}}
            <flux:modal name="submit_warning" class="md:w-96">
                <div class="space-y-6">
                    <flux:heading size="lg">{{ __('Konfirmasi') }}</flux:heading>
                    <div class="flex gap-4">
                        <flux:icon.exclamation-triangle class="size-12 text-orange-500" />
                        <flux:text>{{ __('appointment.create_msg') }}</flux:text>
                    </div>
                    <div class="flex justify-end">
                        <flux:modal.close>
                            <flux:button type="submit" variant="primary" >{{ __('understand') }}</flux:button>
                        </flux:modal.close>
                    </div>
                </div>
            </flux:modal>
            {{-- / Modal Submit --}}
        </form>
    </div>
</div>
{{-- / Form Card --}}