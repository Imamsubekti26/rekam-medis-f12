<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Header --}}
        <header class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 p-6 md:p-12 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                {{-- Title Page --}}
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                    {{ __("doctor.title") }}
                </h2>
                {{-- / Title Page --}}

                {{-- Action Field --}}
                <div class="flex flex-col gap-4">
                    {{-- Button Create --}}
                    <flux:button href="{{ route('doctor.create') }}" class="cursor-pointer" icon="plus" wire:navigate>{{ __('doctor.title_add') }}</flux:button>

                    {{-- Search Field --}}
                    <form class="flex gap-4 items-center">
                        <flux:input icon="magnifying-glass" placeholder="{{ __('doctor.search_hint') }}" name="search" value="{{ request()->query('search') }}" />
                        <input type="hidden" name="sort_by" value="{{ request()->query('sort_by') }}">
                        <flux:button type="submit" class="cursor-pointer">{{ __('doctor.search') }}</flux:button>
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
                        {{-- Doctor ID --}}
                        <th class="p-4 py-6">{{ __('doctor.id') }}</th>
                        {{-- Doctor Name --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('doctor.name') }}
                                <livewire:components.sorter :asc="'name_asc'" :desc="'name_desc'" />
                            </div>
                        </th>
                        {{-- Doctor Email --}}
                        <th class="p-4 py-6">
                            <div class="flex justify-center items-center gap-2">
                                {{ __('email') }}
                                <livewire:components.sorter :asc="'email_asc'" :desc="'email_desc'" />
                            </div>
                        </th>
                        {{-- Doctor phone --}}
                        <th class="p-4 py-6">{{ __('doctor.phone') }}</th>
                        {{-- Action --}}
                        <th class="p-4 py-6">{{ __('patient.action') }}</th>
                    </tr>
                </thead>
                @if ($doctors)
                    <tbody class="text-center border-b-1">
                        @foreach ($doctors as $doctor)
                            <tr>
                                <td class="p-4">{{ $doctor->id }}</td>
                                <td class="p-4">{{ $doctor->name }}</td>
                                <td class="p-4">{{ $doctor->email }}</td>
                                <td class="p-4">{{ $doctor->phone }}</td>
                                <td class="p-4">
                                    <flux:tooltip content="{{ __('detail') }}">
                                        <flux:button href="{{ route('doctor.show', $doctor->id) }}" icon="information-circle" size="sm" class="cursor-pointer" wire:navigate/>
                                    </flux:tooltip>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
            <footer class="p-4 px-4 md:px-12">
                {{ $doctors->appends(request()->query())->links() }}
            </footer>
        </section>
        {{-- / Table Patient Lists --}}

    </main>
</x-layouts.app>