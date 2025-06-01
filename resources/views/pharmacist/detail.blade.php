<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="py-12">
            {{-- Form Card --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                        {{ __('pharmacist.title_show') }}
                    </h2>
                    <form class="mt-12" action="{{ route('pharmacist.store') }}" method="POST">
                        @csrf
        
                        {{-- Form Input --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Doctor Name --}}
                            <flux:input label="{{ __('pharmacist.name') }} *" name="name" value="{{ $pharmacist->name }}" required />
                            {{-- Email --}}
                            <flux:input type="email" label="{{ __('email') }} *" name="email" value="{{ $pharmacist->email }}" required />
                            {{-- Phone --}}
                            <flux:input inputmode="numeric" label="{{ __('pharmacist.phone') }}" name="phone" value="{{ $pharmacist->phone }}" />
                        </div>
                        {{-- / Form Input --}}
        
                        {{-- Form Action Button --}}
                        <div class="flex flex-col-reverse md:flex-row justify-between gap-4 mt-8">
                            <flux:modal.trigger name="delete_doctor">
                                {{-- Delete Button --}}
                                @if (request()->user()->is_editor)
                                    <flux:button class="cursor-pointer" variant="danger">{{ __('pharmacist.delete') }}</flux:button>
                                @else
                                    <div></div>
                                @endif
                            </flux:modal.trigger>
                            <div class="flex flex-col md:flex-row gap-4">
                                {{-- Update Button --}}
                                @if (request()->user()->is_editor)
                                    <flux:button class="cursor-pointer" type="submit" variant="primary" name="_method" value="PUT">{{ __('pharmacist.update') }}</flux:button>
                                @endif
                                {{-- Back Button --}}
                                <flux:button href="{{ route('pharmacist.index') }}" class="cursor-pointer" wire:navigate>{{ __('back') }}</flux:button>
                            </div>
                        </div>
                        {{-- / Form Action Button --}}
                        
                        {{-- Modal Delete --}}
                        <flux:modal name="delete_doctor" class="md:w-96">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">{{ __('pharmacist.delete') }}</flux:heading>
                                    <flux:subheading>{{ __('pharmacist.delete_msg') }}</flux:subheading>
                                </div>
                                <div class="flex justify-end">
                                    <flux:button type="submit" variant="danger" name="_method" value="DELETE">{{ __('pharmacist.delete') }}
                                    </flux:button>
                                </div>
                            </div>
                        </flux:modal>
                        {{-- / Modal Delete --}}
        
                    </form>
                </div>
            </div>
            {{-- / Form Card --}}
        </div>
    </main>
</x-layouts.app>