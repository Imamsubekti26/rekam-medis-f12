<style>
    /* Sembunyikan panah di layar kecil */
    @media (max-width: 767px) {
        .fa-arrow-right {
            display: none !important;
        }
    }
</style>
<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Alert for Required Data --}}
        <div>
            <div
                class="rounded-xl border border-yellow-300 bg-yellow-100 text-yellow-800 dark:border-yellow-600 dark:bg-yellow-900 dark:text-yellow-200 p-4 text-sm">
                <p><strong class="font-semibold">Perhatian:</strong> Data obat wajib diisi karena akan diintegrasikan ke
                    sistem resep obat/resep dokter.</p>
            </div>
        </div>
        {{-- / Alert for Required Data --}}

        {{-- Header --}}
        <header class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div
                class="flex flex-col md:flex-row items-center justify-between gap-4 p-6 md:p-12 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                {{-- Title Page --}}
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                    {{ __('medicine.title') }}
                </h2>
                {{-- / Title Page --}}

                {{-- Action Field --}}
                <div class="flex flex-col gap-4">
                    {{-- Button Create --}}
                    <flux:button href="{{ route('medicine.create') }}" class="cursor-pointer" icon="plus" wire:navigate>
                        {{ __('medicine.title_add') }}</flux:button>

                    {{-- Search Field --}}
                    <form class="flex gap-4 items-center">
                        <flux:input icon="magnifying-glass" placeholder="{{ __('medicine.search_hint') }}"
                            name="search" value="{{ request()->query('search') }}" />
                        <input type="hidden" name="sort_by" value="{{ request()->query('sort_by') }}">
                        <flux:button type="submit" class="cursor-pointer">{{ __('medicine.search') }}</flux:button>
                    </form>
                    {{-- / Search Field --}}

                </div>
                {{-- / Action Field --}}
            </div>
        </header>
        {{-- / Header --}}

        {{-- Table Patient Lists --}}
        <section
            class="w-full rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 overflow-y-auto">
            <table class="w-full">
                <thead class="border-b-1">
                    <tr>
                        {{-- barcode --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('medicine.barcode') }}
                                <livewire:components.sorter :asc="'barcode_asc'" :desc="'barcode_desc'" />
                            </div>
                        </th>
                        {{-- Medicine Name --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('medicine.name') }}
                                <livewire:components.sorter :asc="'name_asc'" :desc="'name_desc'" />
                            </div>
                        </th>
                        {{-- Stock --}}
                        <th class="p-4 py-6">{{ __('medicine.stock') }}</th>
                        {{-- Price --}}
                        <th class="p-4 py-6">{{ __('medicine.price') }}</th>
                        {{-- Action --}}
                        <th class="p-4 py-6">{{ __('action') }}</th>
                    </tr>
                </thead>
                @if ($medicines)
                    <tbody class="text-center">
                        @foreach ($medicines as $medicine)
                            <tr>
                                <td class="p-4">{{ $medicine->barcode }}</td>
                                <td class="p-4">{{ $medicine->name }}</td>
                                <td class="p-4">{{ $medicine->stock }}</td>
                                <td class="p-4">{{ $medicine->price }}</td>
                                <td class="p-4">
                                    <flux:tooltip content="{{ __('detail') }}">
                                        <flux:button href="{{ route('medicine.show', $medicine->id) }}"
                                            icon="information-circle" size="sm" class="cursor-pointer"
                                            wire:navigate />
                                    </flux:tooltip>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
            <footer class="p-4 px-4 md:px-12 border-t-1">
                {{ $medicines->appends(request()->query())->links() }}
            </footer>
        </section>
        {{-- / Table Patient Lists --}}
        {{-- Instruction Guide --}}
        <section
            class="p-4 md:p-6 rounded-xl border border-blue-300 bg-blue-50 dark:border-blue-600 dark:bg-blue-900 dark:text-blue-100">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500 dark:text-blue-300"></i>
                {{ __('Panduan Pengisian Data Obat') }}
            </h3>

            <div class="flex flex-col md:flex-row md:items-center md:gap-4 text-sm text-blue-900 dark:text-blue-100">
                <div class="flex items-center gap-2 mb-2 md:mb-0">
                    <i
                        class="fas fa-1 text-base bg-blue-200 dark:bg-blue-700 text-blue-900 dark:text-blue-100 px-2 py-1 rounded-full"></i>
                    <span>Masuk ke halaman tambah data obat</span>
                </div>

                <i class="fas fa-arrow-right md:inline hidden text-blue-500"></i>

                <div class="flex items-center gap-2 mb-2 md:mb-0">
                    <i
                        class="fas fa-2 text-base bg-blue-200 dark:bg-blue-700 text-blue-900 dark:text-blue-100 px-2 py-1 rounded-full"></i>
                    <span>Isi data barcode & nama obat sesuai label kemasan</span>
                </div>

                <i class="fas fa-arrow-right md:inline hidden text-blue-500"></i>

                <div class="flex items-center gap-2 mb-2 md:mb-0">
                    <i
                        class="fas fa-3 text-base bg-blue-200 dark:bg-blue-700 text-blue-900 dark:text-blue-100 px-2 py-1 rounded-full"></i>
                    <span>Masukkan stok dan harga obat sesuai dengan data apotek</span>
                </div>

                <i class="fas fa-arrow-right md:inline hidden text-blue-500"></i>

                <div class="flex items-center gap-2">
                    <i
                        class="fas fa-4 text-base bg-blue-200 dark:bg-blue-700 text-blue-900 dark:text-blue-100 px-2 py-1 rounded-full"></i>
                    <span>Klik tombol <strong>Simpan</strong> untuk menyimpan data</span>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>
