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
                @foreach ($prescriptions as $i => $p)
                    <tr class="text-center">
                        {{-- Prescription Lists --}}
                        @if ($p['locked'])
                            <td class="p-2 py-4">{{ $p['medicine_name'] }}</td>
                            <td class="p-2 py-4">{{ $p['schedule'] }}</td>
                            <td class="p-2 py-4">{{ $p['aftermeal'] ? 'after meal' : 'before meal' }}</td>
                            <td class="p-2 py-4">{{ $p['notes'] }}</td>
                        @else
                            <td class="p-2 py-4"><flux:input wire:model="prescriptions.{{ $i }}.medicine_name" /></td>
                            <td class="p-2 py-4"><flux:input wire:model="prescriptions.{{ $i }}.schedule" /></td>
                            <td class="p-2 py-4">
                                <flux:select placeholder="{{ __('choose') }}" wire:model="prescriptions.{{ $i }}.aftermeal">
                                    <flux:select.option value="1">{{ __('medical_record.aftermeal') }}</flux:select.option>
                                    <flux:select.option value="0">{{ __('medical_record.beforemeal') }}</flux:select.option>
                                </flux:select>
                            </td>
                            <td class="p-2 py-4"><flux:input wire:model="prescriptions.{{ $i }}.notes" /></td>
                        @endif
                        {{-- / Prescription Lists --}}

                        {{-- Action Button --}}
                        <td class="p-2 py-4">
                            @if ($p['locked'])
                                <flux:button icon="pencil" variant="ghost" class="cursor-pointer" wire:click="unlockPrescription({{ $i }})" />
                            @else
                                <flux:button icon="check" variant="ghost" class="cursor-pointer" wire:click="lockPrescription({{ $i }})" />
                            @endif
                            <flux:button icon="trash" variant="ghost" class="cursor-pointer" wire:click="removePrescription({{ $i }})" />
                        </td>
                        {{-- / Action Button --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</section>