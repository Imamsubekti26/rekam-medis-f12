<main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="py-12">
        {{-- Form Card --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                    {{ $schedule_id ? __('schedule.title_show') : __('schedule.title_add') }}
                </h2>
                <form class="mt-12"
                    action="{{ $schedule_id ? route('schedule.update', $schedule_id) : route('schedule.store') }}"
                    method="POST">
                    @csrf
                    @method($schedule_id ? 'PUT' : 'POST')

                    {{-- Form Input --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Doctor --}}
                        @if (request()->user()->role == 'admin' && $doctors && count($doctors) > 0 && !$schedule_id)
                            <flux:select name="doctor_id" label="{{ __('doctor.name') }} *" placeholder="{{ __('choose') }}"
                                wire:model="doctor_id">
                                @foreach ($doctors as $doctor)
                                    <flux:select.option value="{{ $doctor->id }}">
                                        {{ $doctor->name }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        @elseif (request()->user()->role == 'doctor' || $schedule_id)
                            <div>
                                <flux:input label="{{ __('doctor.name') }} *" wire:model="doctor_name" readonly
                                    :disabled="!request()->user()->is_editor" />
                                <flux:input type="hidden" name="doctor_id" wire:model="doctor_id" />
                            </div>
                        @else
                            <flux:input label="{{ __('doctor.name') }} *" readonly
                                value="{{ __('No Doctor Available') }}" />
                        @endif

                        {{-- Available Date --}}
                        <flux:input type="date" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                            label="{{ __('schedule.available_date') }} *" name="available_date"
                            :disabled="!request()->user()->is_editor" wire:model="available_date" required />

                        {{-- Start Time --}}
                        <flux:input type="time" label="{{ __('schedule.start_time') }} *" name="start_time"
                            :disabled="!request()->user()->is_editor" wire:model="start_time" required />

                        {{-- End Time --}}
                        <flux:input type="time" label="{{ __('schedule.end_time') }} *" name="end_time"
                            :disabled="!request()->user()->is_editor" wire:model="end_time" required />

                        {{-- Serial Visibility --}}
                        @if (request()->user()->is_editor)
                            <flux:select label="{{ __('schedule.schedule_type') }} *" name="schedule_type"
                                wire:model="schedule_type" wire:change="serialVisibilityChanged" required>
                                <flux:select.option value="Sequential">
                                    {{ __('schedule.schedule_type_sequential') }}
                                </flux:select.option>
                                <flux:select.option value="Random">
                                    {{ __('schedule.schedule_type_random') }}
                                </flux:select.option>
                            </flux:select>
                        @else
                            <flux:input type="text" label="{{ __('schedule.schedule_type') }} *" disabled
                                wire:model="schedule_type" />
                        @endif

                        {{-- Per Patient Time --}}
                        <flux:input type="number"
                            label="{{ $schedule_type == 'Random' ? __('schedule.session_count') : __('schedule.per_patient_time') }} *"
                            name="handle_count" :disabled="!request()->user()->is_editor" wire:model="handle_count"
                            required />

                    </div>

                    {{-- Action Button Form --}}
                    <div class="flex flex-col md:flex-row justify-end gap-4 mt-8">
                        {{-- Submit Button --}}
                        @if (request()->user()->is_editor)
                            <flux:button type="submit" variant='primary' class="cursor-pointer">
                                {{ $schedule_id ? __('schedule.update') : __('schedule.add') }}
                            </flux:button>
                        @endif

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