<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Header --}}
        <header class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div class="p-6 md:p-8 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex justify-between items-start">
                    {{-- Breadcrumbs kiri --}}
                    <x-bread-crumbs />
            
                    {{-- Logo kanan --}}
                    <img src="{{ asset('/assets/img/redesignf21m.png') }}" alt="Logo" class="w-18 sm:w-25 !important h-auto object-contain"
                    />
                </div>

                {{-- Title --}}
                <h2 class="font-semibold text-xl text-center md:text-start text-gray-800 dark:text-gray-200 leading-tight mb-8">
                    {{ __('pharmacist.title') }}
                </h2>
                {{-- / Title --}}

                {{-- Action Field --}}
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    {{-- Search Field --}}
                    <form class="flex gap-4 items-center">
                        <flux:input icon="magnifying-glass" placeholder="{{ __('pharmacist.search_hint') }}" name="search" value="{{ request()->query('search') }}" />
                        <input type="hidden" name="sort_by" value="{{ request()->query('sort_by') }}">
                        <flux:button type="submit" class="cursor-pointer">{{ __('pharmacist.search') }}</flux:button>
                    </form>
                    {{-- / Search Field --}}

                    {{-- Button Field --}}
                    <div class="flex flex-col md:flex-row gap-4">
                        {{-- Button Create --}}
                        @if (request()->user()->is_editor)
                            <flux:button href="{{ route('pharmacist.create') }}" class="cursor-pointer !bg-custom-2 hover:!bg-blue-400 !text-white dark:!bg-custom-50 dark:hover:!bg-purple-600" icon="plus" wire:navigate>{{ __('pharmacist.title_add') }}</flux:button>
                        @endif

                        {{-- Button Print --}}
                        <flux:button
                            onclick="window.open(`{{ route('pharmacist.print.list', [
                                'search' => request()->query('search'),
                                'sort_by' => request()->query('sort_by'),
                            ]) }}`)"
                            class="cursor-pointer !bg-slate-500 hover:!bg-slate-400 !text-white dark:!bg-zinc-700 dark:hover:!bg-zinc-600" icon="printer">
                            {{ __('pharmacist.print') }}
                        </flux:button>
                    </div>
                    {{-- / Button Field --}}

                </div>
                {{-- / Action Field --}}
            </div>
        </header>
        {{-- / Header --}}

        {{-- Table Patient Lists --}}
        <section class="w-full rounded-2xl border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-900 overflow-y-auto">
            <table class="w-full">
                <thead class="border-b-1">
                    <tr>
                        {{-- Pharmacist ID --}}
                        <th class="p-4 py-6">{{ __('pharmacist.id') }}</th>
                        {{-- Pharmacist Name --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('pharmacist.name') }}
                                <livewire:components.sorter :asc="'name_asc'" :desc="'name_desc'" />
                            </div>
                        </th>
                        {{-- Pharmacist Email --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('email') }}
                                <livewire:components.sorter :asc="'email_asc'" :desc="'email_desc'" />
                            </div>
                        </th>
                        {{-- Pharmacist phone --}}
                        <th class="p-4 py-6">{{ __('pharmacist.phone') }}</th>
                        {{-- Action --}}
                        <th class="p-4 py-6">{{ __('patient.action') }}</th>
                    </tr>
                </thead>
                @if ($pharmacists)
                    <tbody class="text-center border-b-1">
                        @foreach ($pharmacists as $pharmacist)
                        <tr class="hover:bg-blue-100 dark:hover:bg-slate-700 transition even:bg-blue-50 dark:even:bg-slate-800">
                                <td class="p-4">{{ $pharmacist->id }}</td>
                                <td class="p-4">{{ $pharmacist->name }}</td>
                                <td class="p-4">{{ $pharmacist->email }}</td>
                                <td class="p-4">{{ $pharmacist->phone }}</td>
                                <td class="p-4">
                                    <flux:tooltip content="{{ __('detail') }}">
                                        <flux:button href="{{ route('pharmacist.show', $pharmacist->id) }}" icon="information-circle" size="sm" class="cursor-pointer !bg-custom-2 !text-white dark:!bg-yellow-500 dark:hover:!bg-yellow-400" wire:navigate/>
                                    </flux:tooltip>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
            <footer class="p-4 px-4 md:px-12">
                {{ $pharmacists->appends(request()->query())->links() }}
            </footer>
        </section>
        {{-- / Table Patient Lists --}}

    </main>
</x-layouts.app>