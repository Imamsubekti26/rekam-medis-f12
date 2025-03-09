<section
    class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">

    <div class="flex justify-between">
        {{-- Title --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
            {{ __('medical_record.title_medicine') }}
        </h2>
        {{-- / Title --}}

        {{-- Button: Add New Prescription--}}
        <div>
            <flux:button icon="plus" wire:click="addNewPrescription">{{ __('medical_record.add_prescription') }}</flux:button>
        </div>
        {{-- / Button: Add New Prescription --}}
    </div>

    {{-- Table Medicine --}}
    <div class="w-full mt-8 overflow-y-auto">
        <table class="w-full min-w-2xl">
            <thead class="border-b-1">
                <tr>
                    <th class="p-4">{{ __('medical_record.medicine_name') }}</th>
                    <th class="p-4">{{ __('medical_record.rule_of_use') }}</th>
                    <th class="p-4">{{ __('medical_record.condition') }}</th>
                    <th class="p-4">{{ __('medical_record.notes') }}</th>
                    <th class="p-4"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prescriptions as $p)
                    <livewire:components.prescription :key="$p['id']" :data="$p" />
                @endforeach
            </tbody>
        </table>
    </div>

</section>