<x-layouts.auth.simple>
    <div class="absolute right-0 top-0 mt-2 mr-2">
        <flux:menu.radio.group x-data x-model="$flux.appearance" variant="segmented"
            class="flex cursor-pointer bg-gray-400 dark:bg-gray-600/50 rounded-xl p-2 shadow-lg">
            <flux:radio value="light" icon="sun" class="py-1 cursor-pointer" />
            <flux:radio value="dark" icon="moon" class="py-1 cursor-pointer" />
        </flux:menu.radio.group>
    </div>
    <div
        class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
            <div class="flex-1 p-6 pb-12 rounded-lg text-center">
                <!-- Logo untuk mode terang -->
                <div class="mb-5">
                    <img src="{{ asset('/assets/img/logof21warna.png') }}" alt="Logo Light" class="block dark:hidden"
                        style="width: 100px; margin: 0 auto;">

                    <!-- Logo untuk mode gelap -->
                    <img src="{{ asset('/assets/img/logof21.png') }}" alt="Logo Dark" class="hidden dark:block"
                        style="width: 100px; margin: 0 auto;">
                </div>
                <h2 class="mb-1">Layanan Janji Temu Dokter</h2>
                <h1 class="mb-1 font-bold text-2xl">Apotek F21 Minomartani</h1>

                <div class="flex flex-col justify-center items-center mt-12 gap-4">
                    {{-- Tombol atas (Daftar + Login) --}}
                    <div class="flex flex-col md:flex-row gap-4">
                        <flux:modal.trigger name="register">
                            <flux:button variant="primary" class="cursor-pointer w-40">
                                Daftar Sekarang
                            </flux:button>
                        </flux:modal.trigger>

                        <flux:button href="{{ route('login') }}" variant="filled" class="cursor-pointer w-40"
                            wire:navigate>
                            Login Admin
                        </flux:button>
                    </div>

                    {{-- Tombol bawah (Lihat Jadwal Dokter) --}}
                    <flux:button href="{{ route('schedule.public') }}" variant="outline" class="cursor-pointer w-40"
                        wire:navigate>
                        Lihat Jadwal Tersedia
                    </flux:button>
                </div>


            </div>
    </div>
    </main>
    </div>

    {{-- Modal Register --}}
    <flux:modal name="register" class="bg-zinc-50 dark:bg-zinc-900">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
            {{ __('appointment.title_add') }}
        </h2>
        <livewire:components.appointment-form />
    </flux:modal>
    {{-- / Modal Register --}}
</x-layouts.auth.simple>
