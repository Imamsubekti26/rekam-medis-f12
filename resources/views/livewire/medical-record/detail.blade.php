<main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <livewire:medical-record.card-patient :patient="$record->patient" />
    <livewire:medical-record.card-record :record="$record" />
    <livewire:medical-record.card-prescription :prescriptions="$prescriptions" />
    <section
        class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-6 md:px-8">
        <div class="flex flex-col md:flex-row justify-end gap-4">
            <flux:button 
            href="{{ route('patient.show', $record->patient->id) }}" 
            icon="user" 
            class="cursor-pointer !bg-blue-600 !text-white dark:!bg-custom-50 dark:hover:!bg-purple-700 transition duration-200 ease-in-out rounded-md shadow"
            wire:navigate>
            {{ __('patient.title_medic') }}
        </flux:button>
            @if (request()->user()->is_editor)
                <flux:modal.trigger name="delete_record">
                    <flux:button class="cursor-pointer" variant="danger">{{ __('medical_record.delete') }}</flux:button>
                </flux:modal.trigger>
            @endif
            <flux:button class="cursor-pointer" @click="window.open(`{{ route('record.print.detail', $record->id) }}`)">{{ __('medical_record.print_report') }}</flux:button>
            @if (request()->user()->is_editor)
                <flux:button variant="primary" class="cursor-pointer" wire:click="updateData">{{ __('medical_record.save') }}
            @endif
            </flux:button>
            <flux:button @click="window.history.back()" class="cursor-pointer" wire:navigate>{{ __('back') }}
            </flux:button>
        </div>
    </section>

    {{-- Modal Delete --}}
    <flux:modal name="delete_record" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('medical_record.delete') }}</flux:heading>
                <flux:subheading>{{ __('medical_record.delete_msg') }}</flux:subheading>
            </div>
            <form method="POST" action="{{ route('record.destroy', $record->id) }}" class="flex justify-end">
                @csrf
                <flux:button type="submit" variant="danger" name="_method" value="DELETE">{{ __('medical_record.delete') }}
                </flux:button>
            </form>
        </div>
    </flux:modal>
    {{-- / Modal Delete --}}
</main>