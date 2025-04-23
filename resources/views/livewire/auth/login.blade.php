<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
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

    <x-auth-header title="Masuk ke Akun Anda" description="Masukkan email dan kata sandi Anda untuk Log-in" />

    <!-- Status Sesi -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Alamat Email -->
        <flux:input wire:model="email" label="Alamat Email" type="email" name="email" required autofocus
            autocomplete="email" placeholder="email@contoh.com" />

        <!-- Kata Sandi -->
        <div class="relative">
            <flux:input wire:model="password" label="Kata Sandi" type="password" name="password" required
                autocomplete="current-password" placeholder="Kata Sandi" />

            @if (Route::has('password.request'))
                <flux:link class="absolute right-0 top-0 text-sm" href="{{ route('password.request') }}" wire:navigate>
                    Lupa kata sandi?
                </flux:link>
            @endif
        </div>

        <!-- Ingat Saya -->
        <flux:checkbox wire:model="remember" label="Ingat saya" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full cursor-pointer">Masuk</flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        Belum punya akun?
        <flux:link href="{{ route('register') }}" wire:navigate>Daftar</flux:link>
    </div>
</div>
