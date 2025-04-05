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
    <img src="/build/assets/img/logof21.png" alt="" style="width: 100px; margin: 0 auto;">
    <x-auth-header 
        title="Buat akun" 
        description="Masukkan data diri Anda untuk membuat akun" 
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Nama -->
        <flux:input
            wire:model="name"
            id="name"
            label="Nama lengkap"
            type="text"
            name="name"
            required
            autofocus
            autocomplete="name"
            placeholder="Nama lengkap"
        />

        <!-- Alamat Email -->
        <flux:input
            wire:model="email"
            id="email"
            label="Alamat email"
            type="email"
            name="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Kata Sandi -->
        <flux:input
            wire:model="password"
            id="password"
            label="Kata sandi"
            type="password"
            name="password"
            required
            autocomplete="new-password"
            placeholder="Kata sandi"
        />

        <!-- Konfirmasi Kata Sandi -->
        <flux:input
            wire:model="password_confirmation"
            id="password_confirmation"
            label="Konfirmasi kata sandi"
            type="password"
            name="password_confirmation"
            required
            autocomplete="new-password"
            placeholder="Konfirmasi kata sandi"
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                Buat akun
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        Sudah punya akun?
        <flux:link href="{{ route('login') }}" wire:navigate>Masuk</flux:link>
    </div>
</div>

