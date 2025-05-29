<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="py-12">
            {{-- Detail Card --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                        {{ __('schedule.title_show') }}
                    </h2>

                    <form class="mt-12" action="{{ route('schedule.update', $schedule->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Doctor Name --}}
                            <flux:input label="{{ __('doctor.name') }}" value="{{ $schedule->doctor->name }}" readonly />

                            {{-- Available Date --}}
                            <flux:input label="{{ __('schedule.available_date') }}" name="available_date" type="date"
                                value="{{ $schedule->available_date }}" required />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                            {{-- Start Time --}}
                            <flux:input label="{{ __('schedule.start_time') }}" name="start_time" type="time"
                                value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" required />

                            {{-- End Time --}}
                            <flux:input label="{{ __('schedule.end_time') }}" name="end_time" type="time"
                                value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}" required />
                        </div>


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                            {{-- Per Patient Time --}}
                            <flux:input label="{{ __('schedule.per_patient_time') }} (menit)" name="per_patient_time"
                                value="{{ $schedule->per_patient_time . ' menit' }}" required />



                            {{-- Serial Visibility --}}
                            <flux:select label="{{ __('schedule.serial_visibility') }} *"
                                placeholder="{{ __('choose') }}" name="serial_visibility" required>
                                <option value="Sequential"
                                    {{ $schedule->serial_visibility == 'Sequential' ? 'selected' : '' }}>
                                    {{ __('schedule.serial_visibility_sequential') }}
                                </option>
                                <option value="Random"
                                    {{ $schedule->serial_visibility == 'Random' ? 'selected' : '' }}>
                                    {{ __('schedule.serial_visibility_random') }}
                                </option>
                            </flux:select>




                        </div>

                        {{-- Action Button Form --}}
                        <div class="flex flex-col md:flex-row justify-end gap-4 mt-8">
                            {{-- Submit Button --}}
                            <flux:button type="submit" variant='primary' class="cursor-pointer">
                                {{ __('schedule.update') }}
                            </flux:button>

                            {{-- Cancel Button --}}
                            <flux:button class="cursor-pointer" href="{{ route('schedule.index') }}" wire:navigate>
                                {{ __('cancel') }}
                            </flux:button>
                        </div>
                    </form>
                    {{-- / Action Button Form --}}
                </div>
            </div>
            {{-- / Detail Card --}}
        </div>
    </main>
</x-layouts.app>
