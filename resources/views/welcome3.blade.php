<x-layouts.basic>
    <div class="absolute right-0 top-0 mt-2 mr-2">
        <flux:menu.radio.group x-data x-model="$flux.appearance" variant="segmented"
            class="flex cursor-pointer bg-gray-400 dark:bg-gray-600/50 rounded-xl p-2 shadow-lg">
            <flux:radio value="light" icon="sun" class="py-1 cursor-pointer" />
            <flux:radio value="dark" icon="moon" class="py-1 cursor-pointer" />
        </flux:menu.radio.group>
    </div>
    <div class="w-full">
        <div>
            <!-- Logo untuk mode terang -->
            <div class="mb-5 mt-24 md:mt-0">
                <img src="{{ asset('/assets/img/logof21warna.png') }}" alt="Logo Light" class="block dark:hidden"
                    style="width: 100px; margin: 0 auto;">
                <!-- Logo untuk mode gelap -->
                <img src="{{ asset('/assets/img/logof21.png') }}" alt="Logo Dark" class="hidden dark:block"
                    style="width: 100px; margin: 0 auto;">
            </div>

            <h2 class="mb-1 text-center">Layanan Janji Temu Dokter</h2>
            <h1 class="mb-1 text-center font-bold text-2xl">Apotek F21 Minomartani</h1>
        </div>
        <hr class="my-8 border-black dark:border-0" />
        <livewire:components.calendar />
    </div>
</x-layouts.basic>