<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="py-12">
            {{-- Form Card --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                        {{ __('schedule.title_add') }}
                    </h2>
                    <form class="mt-12" action="{{ route('schedule.store') }}" method="POST">
                        @csrf

                        {{-- Form Input --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Doctor --}}
                            @if ($doctors && count($doctors) > 0)
                                <flux:select name="doctor_id" label="{{ __('doctor.name') }} *"
                                    placeholder="{{ __('choose') }}">
                                    @foreach ($doctors as $doctor)
                                        <flux:select.option value="{{ $doctor->id }}">
                                            {{ $doctor->name }}
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>
                            @else
                                <flux:input label="{{ __('doctor.name') }} *" readonly
                                    value="{{ __('No Doctor Available') }}" />
                            @endif

                            {{-- Available Date --}}
                            <flux:input type="date" label="{{ __('schedule.available_date') }} *"
                                name="available_date" required />

                            {{-- Start Time --}}
                            <flux:input type="time" label="{{ __('schedule.start_time') }} *" name="start_time"
                                required />

                            {{-- End Time --}}
                            <flux:input type="time" label="{{ __('schedule.end_time') }} *" name="end_time"
                                required />

                            {{-- Per Patient Time --}}
                            <flux:input type="number" label="{{ __('schedule.per_patient_time') }} (menit) *"
                                name="per_patient_time" required />

                            {{-- Serial Visibility --}}
                            <flux:select label="{{ __('schedule.serial_visibility') }}" name="serial_visibility"
                                required>
                                <flux:select.option value="Sequential">
                                    {{ __('schedule.serial_visibility_sequential') }}
                                </flux:select.option>
                                <flux:select.option value="Random">
                                    {{ __('schedule.serial_visibility_random') }}
                                </flux:select.option>
                            </flux:select>



                        </div>

                        {{-- Action Button Form --}}
                        <div class="flex flex-col md:flex-row justify-end gap-4 mt-8">
                            {{-- Submit Button --}}
                            <flux:button type="submit" variant='primary' class="cursor-pointer">
                                {{ __('schedule.add') }}
                            </flux:button>

                            {{-- Cancel Button --}}
                            <flux:button class="cursor-pointer" href="{{ route('schedule.index') }}" wire:navigate>
                                {{ __('cancel') }}
                            </flux:button>
                        </div>
                        {{-- / Action Button Form --}}

                    </form>
                </div>
            </div>
            {{-- / Form Card --}}
        </div>
    </main>
</x-layouts.app>
