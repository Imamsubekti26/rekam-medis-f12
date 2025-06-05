<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="py-12">
            {{-- Form Card --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                        {{ __("patient.title_add") }}
                    </h2>
                    <form class="mt-12" action="{{ route('patient.store') }}" method="POST">
                        @csrf

                        {{-- Form Input --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Member ID --}}
                            <flux:input label="{{ __('patient.nik') }} *" name="nik" value="{{ old('nik') }}" required />
                            {{-- Name --}}
                            <flux:input label="{{ __('patient.name') }} *" name="name" value="{{ old('name') }}" required />
                            {{-- Address --}}
                            <flux:input label="{{ __('patient.address') }}" name="address" value="{{ old('address') }}" />
                            {{-- Phone --}}
                            <flux:input inputmode="numeric" label="{{ __('patient.phone') }}" name="phone" value="{{ old('phone') }}" />
                            {{-- Gender --}}
                            <flux:select label="{{ __('patient.gender') }} *" placeholder="{{ __('choose') }}" name="is_male" required>
                                <flux:select.option value="1">{{ __('patient.male') }}</flux:select.option>
                                <flux:select.option value="0">{{ __('patient.female') }}</flux:select.option>
                            </flux:select>
                            {{-- Date of Birth --}}
                            <flux:input type="date" label="{{ __('patient.date_of_birth') }}" name="date_of_birth" value="{{ old('date_of_birth') }}"/>
                            {{-- Drug Allergies --}}
                            <flux:textarea label="{{ __('patient.drug_allergies') }}" resize="none" name="drug_allergies">{{ old('drug_allergies') }}</flux:textarea>
                            {{-- Food Allergies --}}
                            <flux:textarea label="{{ __('patient.food_allergies') }}" resize="none" name="food_allergies">{{ old('food_allergies') }}</flux:textarea>
                        </div>
                        {{-- / Form Input --}}

                        {{-- Action Button Form --}}
                        <div class="flex flex-col md:flex-row justify-end gap-4 mt-8">
                            {{-- Submit Button --}}
                            @if (request()->user()->is_editor)
                                <flux:button type="submit" variant='primary' class="cursor-pointer">{{ __('patient.add') }}</flux:button>
                            @endif
                            {{-- Cancel Button --}}
                            <flux:button class="cursor-pointer" href="{{ route('patient.index') }}" wire:navigate>{{ __('cancel') }}</flux:button>
                        </div>
                        {{-- / Action Button Form --}}

                    </form>
                </div>
            </div>
            {{-- / Form Card --}}
        </div>
    </main>
</x-layouts.app>