@php
    use Carbon\Carbon;
@endphp
{{-- Form Card Update --}}
<header
    class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-visible shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">

    {{-- Title --}}
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
        {{ __('patient.title_show') }}
    </h2>
    {{-- / Title --}}

    <div class="mt-12">
        @if ($patient_id != null)
            {{-- Form Input --}}
            <div class="grid auto-rows-min gap-4 md:grid-cols-3 xl:grid-cols-4 mt-12 mb-8">
                {{-- Member ID --}}
                <flux:input label="{{ __('patient.member_id') }} *" value="{{ $patient_data->member_id }}" disabled />
                {{-- Name --}}
                <flux:input label="{{ __('patient.name') }} *" value="{{ $patient_data->name }}" disabled />
                {{-- Gender --}}
                <flux:select label="{{ __('patient.gender') }} *" placeholder="{{ __('choose') }}" disabled>
                    <option value="1" {{ $patient_data->is_male ? 'selected' : '' }}>{{ __('patient.male') }}
                    </option>
                    <option value="0" {{ !$patient_data->is_male ? 'selected' : '' }}>{{ __('patient.female') }}
                    </option>
                </flux:select>
                {{-- Age --}}
                <flux:input type="text" label="{{ __('patient.age') }}"
                    value="{{ Carbon::createFromDate($patient_data->date_of_birth)->age }}" disabled />
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-2 mt-4 mb-8">
                {{-- Drug Allergies --}}
                <flux:textarea label="{{ __('patient.drug_allergies') }}" resize="none" disabled>
                    {{ $patient_data->drug_allergies }}</flux:textarea>
                {{-- Food Allergies --}}
                <flux:textarea label="{{ __('patient.food_allergies') }}" resize="none" disabled>
                    {{ $patient_data->food_allergies }}</flux:textarea>
            </div>
            {{-- / Form Input --}}
        @else
            <form class="relative w-full max-w-md flex flex-col gap-2" wire:submit.prevent="findPatientById">
                <div class="flex gap-4 items-center">
                    <flux:input wire:model.debounce.300ms="member_id" wire:keydown="findPatientById"
                        placeholder="{{ __('patient.search_id') }}" />
                    <flux:button type="submit" variant="primary" class="cursor-pointer">
                        {{ __('patient.search') }}
                    </flux:button>
                </div>

                @if (!empty($suggestions))
                    <ul
                        class="absolute left-0 top-full mt-2 w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg z-50 max-h-60 overflow-auto transition-all duration-200">
                        @foreach ($suggestions as $suggestion)
                            <li wire:click="setPatient('{{ $suggestion->id }}')"
                                class="px-4 py-2 text-sm text-zinc-800 dark:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer transition-colors duration-150">
                                <span class="font-semibold">{{ $suggestion->member_id }}</span>
                                <span class="text-zinc-500 ml-2">{{ $suggestion->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </form>

        @endif
    </div>
</header>
{{-- / Form Card Update --}}
