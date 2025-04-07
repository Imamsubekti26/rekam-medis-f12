<tr class="text-center">
    {{-- Prescription Lists --}}
    @if (!$in_edit)
        <td class="p-2 py-4">{{ $medicine_name }}</td>
        <td class="p-2 py-4">{{ $rule_of_use }}</td>
        <td class="p-2 py-4">{{ $aftermeal ? 'after meal' : 'before meal' }}</td>
        <td class="p-2 py-4">{{ $notes }}</td>
    @else
        <td class="p-2 py-4"><livewire:components.livesearch :search_key="$medicine_name" /></td>
        @if ($medicine_id == "")
            <td class="p-2 py-4"><flux:input disabled/></td>
            <td class="p-2 py-4"><flux:input value="-" disabled /></td>
            <td class="p-2 py-4"><flux:input disabled /></td>
        @else
            <td class="p-2 py-4">
                <flux:input wire:model="rule_of_use" />
            </td>
            <td class="p-2 py-4">
                <flux:select placeholder="{{ __('choose') }}" wire:model="aftermeal">
                    <flux:select.option value="1">{{ __('medical_record.aftermeal') }}</flux:select.option>
                    <flux:select.option value="0">{{ __('medical_record.beforemeal') }}</flux:select.option>
                </flux:select>
            </td>
            <td class="p-2 py-4">
                <flux:input wire:model="notes" />
            </td>
        @endif
    @endif
    {{-- / Prescription Lists --}}

    {{-- Action Button --}}
    <td class="p-2 py-4">
        @if (!$in_edit)
            <flux:button icon="pencil" variant="ghost" class="cursor-pointer" wire:click="unlockPrescription" />
        @else
            <flux:button icon="check" variant="ghost" class="cursor-pointer" wire:click="lockPrescription" />
        @endif
        <flux:button icon="trash" variant="ghost" class="cursor-pointer" wire:click="removePrescription" />
    </td>
    {{-- / Action Button --}}
</tr>