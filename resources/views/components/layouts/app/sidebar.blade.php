<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo class="size-8" href="#"></x-app-logo>
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group heading="{{ __('dashboard.menu_utama') }}" class="grid">
                    <flux:navlist.item
                        icon="home"
                        :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')"
                        wire:navigate
                        class="{{ request()->routeIs('dashboard') ? 'flux-navlist-item-active' : '' }}">
                        {{ __('dashboard.dashboard') }}
                    </flux:navlist.item>

                    <flux:navlist.item
                        icon="document-text"
                        :href="route('record.index')"
                        :current="request()->routeIs('record.index')"
                        wire:navigate
                        class="{{ request()->routeIs('record.index') ? 'flux-navlist-item-active' : '' }}">
                        {{ __('dashboard.medical_record') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group heading="{{ __('dashboard.manage_data') }}" class="grid">
                    @php
$role = auth()->user()->role;
                    @endphp
                    @if (in_array($role, ['admin', 'doctor', 'pharmacist']))
                    <flux:navlist.item
                        icon="users"
                        :href="route('patient.index')"
                        :current="request()->routeIs('patient.index')"
                        wire:navigate
                        class="{{ request()->routeIs('patient.index') ? 'flux-navlist-item-active' : '' }}">
                        {{ __('dashboard.patient') }}
                    </flux:navlist.item>
                    @endif
                    @if ($role === 'admin')
                    <flux:navlist.item
                        icon="user"
                        :href="route('doctor.index')"
                        :current="request()->routeIs('doctor.index')"
                        wire:navigate
                        class="{{ request()->routeIs('doctor.index') ? 'flux-navlist-item-active' : '' }}">
                        {{ __('dashboard.doctor') }}
                    </flux:navlist.item>

                    <flux:navlist.item
                        icon="user"
                        :href="route('pharmacist.index')"
                        :current="request()->routeIs('pharmacist.index')"
                        wire:navigate
                        class="{{ request()->routeIs('pharmacist.index') ? 'flux-navlist-item-active' : '' }}">
                        {{ __('dashboard.pharmacist') }}
                    </flux:navlist.item>
                    @endif
                    @if (in_array($role, ['admin', 'pharmacist']))
                    <flux:navlist.item
                        icon="inbox"
                        :href="route('medicine.index')"
                        :current="request()->routeIs('medicine.index')"
                        wire:navigate
                        class="{{ request()->routeIs('medicine.index') ? 'flux-navlist-item-active' : '' }}">
                        {{ __('dashboard.medicine') }}
                    </flux:navlist.item>
                    @endif

                    <flux:navlist.group expandable heading="Jadwal & Janji Temu">
                        {{-- Jadwal Dokter --}}
                        <flux:navlist.item :href="route('schedule.index')" :current="request()->routeIs('schedule.index')" wire:navigate class="{{ request()->routeIs('schedule.index') ? 'flux-navlist-item-active' : '' }}"> {{ __('dashboard.schedule') }}</flux:navlist.item>
                        {{-- Janji Temu --}}
                        <flux:navlist.item :href="route('appointment.index')" :current="request()->routeIs('appointment.index')" wire:navigate class="{{ request()->routeIs('appointment.index') ? 'flux-navlist-item-active' : '' }}"> {{ __('dashboard.appointment') }}</flux:navlist.item>
                        {{-- Kalender --}}
                        <flux:navlist.item :href="route('schedule.calendar')" :current="request()->routeIs('schedule.calendar')" wire:navigate class="{{ request()->routeIs('schedule.calendar') ? 'flux-navlist-item-active' : '' }}"> {{ __('dashboard.calendar') }}</flux:navlist.item>
                    </flux:navlist.group>

                </flux:navlist.group>
            </flux:navlist>


            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
            <!-- Theme Switcher -->
            <flux:menu.radio.group x-data x-model="$flux.appearance" variant="segmented" class="hidden lg:flex mr-2 cursor-pointer">
                <flux:radio value="light" icon="sun" class="py-1" />
                <flux:radio value="dark" icon="moon" class="py-1" />
            </flux:menu.radio.group>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
             <!-- Theme Switcher -->
            <flux:menu.radio.group x-data x-model="$flux.appearance" variant="segmented" class="flex lg:hidden mt-2 ml-2">
                <flux:radio value="light" icon="sun" class="py-1" />
                <flux:radio value="dark" icon="moon" class="py-1" />
            </flux:menu.radio.group>
            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
           

        </flux:header>

        {{ $slot }}

        @fluxScripts

        <script>
            window.x_layout = 'Dashboard';
        </script>
    </body>
</html>
