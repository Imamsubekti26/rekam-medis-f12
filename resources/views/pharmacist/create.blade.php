<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="py-12">
            {{-- Form Card --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                        {{ __('pharmacist.title_add') }}
                    </h2>
                    <form class="mt-12" action="{{ route('pharmacist.store') }}" method="POST">
                        @csrf

                        {{-- Form Input --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Pharmacist Name --}}
                            <flux:input label="{{ __('pharmacist.name') }} *" name="name" value="{{ old('name') }}" required />
                            {{-- Email --}}
                            <flux:input type="email" label="{{ __('email') }} *" name="email" value="{{ old('email') }}" required />
                            {{-- Password --}}
                            <flux:input type="password" label="{{ __('password') }} *" name="password" viewable required />
                            {{-- Confirmation Password --}}
                            <flux:input type="password" label="{{ __('pharmacist.confirmation_password') }} *" name="password_confirmation" viewable required />
                        </div>
                        {{-- / Form Input --}}

                        {{-- Action Button Form --}}
                        <div class="flex flex-col md:flex-row justify-end gap-4 mt-8">
                            {{-- Submit Button --}}
                            <flux:button type="submit" variant='primary' class="cursor-pointer">{{ __('pharmacist.add') }}</flux:button>
                            {{-- Cancel Button --}}
                            <flux:button class="cursor-pointer" href="{{ route('pharmacist.index') }}" wire:navigate>{{ __('cancel') }}</flux:button>
                        </div>
                        {{-- / Action Button Form --}}

                    </form>
                </div>
            </div>
            {{-- / Form Card --}}
        </div>
    </main>
</x-layouts.app>