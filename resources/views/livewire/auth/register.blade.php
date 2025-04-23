<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <!-- Theme Switcher kanan atas -->
    <div class="absolute right-0 top-0 mt-2 mr-2">
        <flux:menu.radio.group x-data x-model="$flux.appearance" variant="segmented" class="flex cursor-pointer">
            <flux:radio value="light" icon="sun" class="py-1 cursor-pointer" />
            <flux:radio value="dark" icon="moon" class="py-1 cursor-pointer" />
        </flux:menu.radio.group>
    </div>

    <!-- Logo untuk mode terang -->
    <img src="{{ asset('/assets/img/logof21warna.png') }}" alt="Logo Light" class="block dark:hidden"
        style="width: 100px; margin: 0 auto;">

    <!-- Logo untuk mode gelap -->
    <img src="{{ asset('/assets/img/logof21.png') }}" alt="Logo Dark" class="hidden dark:block"
        style="width: 100px; margin: 0 auto;">
    <x-auth-header title="Buat akun" description="Masukkan data diri Anda untuk membuat akun" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Nama -->
        <flux:input wire:model="name" id="name" label="Nama lengkap" type="text" name="name" required
            autofocus autocomplete="name" placeholder="Nama lengkap" />

        <!-- Alamat Email -->
        <flux:input wire:model="email" id="email" label="Alamat email" type="email" name="email" required
            autocomplete="email" placeholder="email@example.com" />

        <!-- Kata Sandi -->
        <flux:input wire:model="password" id="password" label="Kata sandi" type="password" name="password" required
            autocomplete="new-password" placeholder="Kata sandi" />

        <!-- Konfirmasi Kata Sandi -->
        <flux:input wire:model="password_confirmation" id="password_confirmation" label="Konfirmasi kata sandi"
            type="password" name="password_confirmation" required autocomplete="new-password"
            placeholder="Konfirmasi kata sandi" />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full cursor-pointer">
                Buat akun
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        Sudah punya akun?
        <flux:link href="{{ route('login') }}" wire:navigate>Masuk</flux:link>
    </div>
</div>
