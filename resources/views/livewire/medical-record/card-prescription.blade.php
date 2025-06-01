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
            @if (request()->user()->is_editor)
                <flux:button icon="plus" wire:click="addNewPrescription">{{ __('medical_record.add_prescription') }}</flux:button>
            @endif
        </div>
        {{-- / Button: Add New Prescription --}}
    </div>

    {{-- Table Medicine --}}
    <div class="w-full mt-8 overflow-y-auto">
        @if ($prescriptions)
            <table class="w-full min-h-[200px] min-w-2xl">
                <thead class="border-b-1">
                    <tr>
                        <th class="p-4">{{ __('medical_record.medicine_name') }}</th>
                        <th class="p-4">{{ __('medical_record.rule_of_use') }}</th>
                        <th class="p-4">{{ __('medical_record.condition') }}</th>
                        <th class="p-4">{{ __('medical_record.notes') }}</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="[&>tr:nth-child(even)]:bg-blue-50 [&>tr:nth-child(even)]:dark:bg-slate-800 transition-all duration-300 ease-in-out">
                    @foreach ($prescriptions as $p)
                        <livewire:components.prescription :key="$p['id']" :data="$p" />
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="w-full h-full flex justify-center items-center py-5">
                <p class="italic">{{ __('medical_record.empty_prescriptions') }}</p>
            </div>
        @endif
    </div>

    {{-- Alert Info --}}
    <div class="mt-6 w-full bg-yellow-100 dark:bg-yellow-800 text-sm text-yellow-900 dark:text-yellow-100 p-4 rounded-lg shadow-md flex items-start gap-2">
        <i class="fas fa-info-circle mt-1"></i>
        <div>
            <p><strong>Perhatian:</strong> Pastikan obat yang akan ditambahkan ke dalam resep dokter sudah terdaftar pada daftar obat dan harap klik obat yang muncul dibawahnya.</p>
        </div>
    </div>

</section>