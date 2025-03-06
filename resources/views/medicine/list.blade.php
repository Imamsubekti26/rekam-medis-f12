<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Header --}}
        <header class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 p-6 md:p-12 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                {{-- Title Page --}}
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                    {{ __("medicine.title") }}
                </h2>
                {{-- / Title Page --}}

                {{-- Action Field --}}
                <div class="flex flex-col gap-4">
                    {{-- Button Create --}}
                    <flux:button href="{{ route('medicine.create') }}" class="cursor-pointer" icon="plus" wire:navigate>{{ __('medicine.title_add') }}</flux:button>

                    {{-- Search Field --}}
                    <form class="flex gap-4 items-center">
                        <flux:input icon="magnifying-glass" placeholder="{{ __('medicine.search_hint') }}" name="search" value="{{ request()->query('search') }}" />
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
        <section class="w-full rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 overflow-y-auto">
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
                                        <flux:button href="{{ route('medicine.show', $medicine->id) }}" icon="information-circle" size="sm" class="cursor-pointer" wire:navigate/>
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

    </main>
</x-layouts.app>