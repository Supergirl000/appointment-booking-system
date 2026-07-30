<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form
        method="POST"
        action="{{ route('login') }}"
        x-data="{
            useDemoAccount() {
                $refs.email.value = 'demo@lumiere.com';
                $refs.password.value = 'demo123';
                $refs.email.dispatchEvent(new Event('input', { bubbles: true }));
                $refs.password.dispatchEvent(new Event('input', { bubbles: true }));
            },
        }"
    >
        @csrf

        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-950">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-bold text-slate-950 dark:text-white">Demo Access</p>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Use the public demo account to explore the booking admin safely.</p>
                </div>

                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-800 dark:hover:text-white dark:focus:ring-slate-600 dark:focus:ring-offset-slate-950"
                    @click="useDemoAccount()"
                >
                    Use Demo Account
                </button>
            </div>

            <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                <div class="rounded-md bg-white px-3 py-2 dark:bg-slate-900">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Email</dt>
                    <dd class="mt-1 font-semibold text-slate-950 dark:text-white">demo@lumiere.com</dd>
                </div>
                <div class="rounded-md bg-white px-3 py-2 dark:bg-slate-900">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Password</dt>
                    <dd class="mt-1 font-semibold text-slate-950 dark:text-white">demo123</dd>
                </div>
            </dl>
        </div>

        <!-- Email Address -->
        <div class="mt-5">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input x-ref="email" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input x-ref="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-slate-300">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-slate-300 dark:hover:text-white dark:focus:ring-offset-slate-950" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>