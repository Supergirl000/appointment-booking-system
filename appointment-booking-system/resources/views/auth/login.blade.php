
<x-guest-layout>
    <div class="mb-7">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">
            Welcome back
        </h1>
        <p class="mt-2 text-sm text-slate-500">
            Sign in to manage your appointments and clients.
        </p>
    </div>

    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <form
        method="POST"
        action="{{ route('login') }}"
        class="space-y-5"
        x-data="{
            useDemoAccount() {
                $refs.email.value = 'demo@lumiere.com';
                $refs.password.value = 'demo123';
                $refs.email.dispatchEvent(new Event('input', { bubbles: true }));
                $refs.password.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }"
    >
        @csrf

        <!-- Demo Access -->
        <div class="rounded-2xl border border-indigo-100 bg-indigo-50/70 p-5">
            <div class="flex flex-col gap-3">
                <div>
                    <p class="font-semibold text-slate-900">
                        {{ __('Demo Access') }}
                    </p>
                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        Explore Appointly using our public demo account.
                    </p>
                </div>

                <button
                    type="button"
                    @click="useDemoAccount()"
                    class="w-full rounded-xl border border-indigo-200 bg-white px-4 py-3 text-sm font-semibold text-indigo-800 transition hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    {{ __('Use Demo Account') }}
                </button>
            </div>
        </div>

        <!-- Email -->
        <div>
            <x-input-label
                for="email"
                :value="__('Email Address')"
                class="mb-2 text-sm font-semibold text-slate-700"
            />

            <x-text-input
                x-ref="email"
                id="email"
                class="block w-full rounded-xl border-slate-200 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="you@example.com"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <!-- Password -->
        <div>
            <x-input-label
                for="password"
                :value="__('Password')"
                class="mb-2 text-sm font-semibold text-slate-700"
            />

            <x-text-input
                x-ref="password"
                id="password"
                class="block w-full rounded-xl border-slate-200 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>

        <!-- Remember Me -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                />
                <span class="text-sm text-slate-600">
                    {{ __('Remember me') }}
                </span>
            </label>

            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    class="text-sm font-semibold text-indigo-700 hover:text-indigo-900"
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button
            type="submit"
            class="w-full rounded-xl bg-indigo-800 px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
            {{ __('Log in') }}
        </button>
    </form>
</x-guest-layout>
