<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-slate-400">
            {{ $user->is_demo ? __('Profile changes are disabled in demo mode.') : __("Update your account's profile information and email address.") }}
        </p>
    </header>

    @if ($user->is_demo)
        <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-800 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-200">
            <p class="font-semibold">{{ __('Profile changes are disabled in demo mode.') }}</p>
            <p class="mt-1">{{ __('This keeps the public demo login stable for every visitor.') }}</p>
        </div>

        <dl class="mt-6 grid gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Name') }}</dt>
                <dd class="mt-1 rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-950 dark:border-slate-700 dark:bg-slate-950 dark:text-white">{{ $user->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Email') }}</dt>
                <dd class="mt-1 rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-950 dark:border-slate-700 dark:bg-slate-950 dark:text-white">{{ $user->email }}</dd>
            </div>
        </dl>
    @else
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-slate-300">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-slate-300 dark:hover:text-white dark:focus:ring-offset-slate-950">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-slate-400"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    @endif
</section>