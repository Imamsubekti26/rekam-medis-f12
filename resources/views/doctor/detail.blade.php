<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Form Card Update --}}
        <header class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">

            {{-- Title --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                {{ __("doctor.title_show") }}
            </h2>
            {{-- / Title --}}

            <form action="{{ route('doctor.update', $doctor->id) }}" method="POST">
                @csrf
                {{-- Form Input --}}
                <div class="grid auto-rows-min gap-4 md:grid-cols-3 mt-12 mb-8">
                    {{-- Doctor Name --}}
                    <flux:input label="{{ __('doctor.name') }} *" name="name" value="{{ $doctor->name }}" required />
                    {{-- Email --}}
                    <flux:input type="email" label="{{ __('email') }} *" name="email" value="{{ $doctor->email }}" required />
                    {{-- Phone --}}
                    <flux:input inputmode="numeric" label="{{ __('doctor.phone') }}" name="phone" value="{{ $doctor->phone }}" />
                </div>
                {{-- / Form Input --}}

                {{-- Form Action Button --}}
                <div class="flex flex-col-reverse md:flex-row justify-between gap-4">
                    <flux:modal.trigger name="delete_doctor">
                        {{-- Delete Button --}}
                        <flux:button class="cursor-pointer" variant="danger">{{ __('doctor.delete') }}</flux:button>
                    </flux:modal.trigger>
                    <div class="flex flex-col md:flex-row gap-4">
                        {{-- Update Button --}}
                        <flux:button class="cursor-pointer" type="submit" variant="primary" name="_method" value="PUT">{{ __('doctor.update') }}</flux:button>
                        {{-- Back Button --}}
                        <flux:button href="{{ route('doctor.index') }}" class="cursor-pointer" wire:navigate>{{ __('back') }}</flux:button>
                    </div>
                </div>
                {{-- / Form Action Button --}}

                {{-- Modal Delete --}}
                <flux:modal name="delete_doctor" class="md:w-96">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">{{ __('doctor.delete') }}</flux:heading>
                            <flux:subheading>{{ __('doctor.delete_msg') }}</flux:subheading>
                        </div>
                        <div class="flex justify-end">
                            <flux:button type="submit" variant="danger" name="_method" value="DELETE">{{ __('doctor.delete') }}</flux:button>
                        </div>
                    </div>
                </flux:modal>
                {{-- / Modal Delete --}}
            </form>
        </header>
        {{-- / Form Card Update --}}

        {{-- Form Card Medical Record Lists --}}
        <section class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
            {{-- Title --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                {{ __("doctor.title_medic") }}
            </h2>
            {{-- / Title --}}
        </section>
        {{-- / Form Card Medical Record Lists --}}
    </main>
</x-layouts.app>