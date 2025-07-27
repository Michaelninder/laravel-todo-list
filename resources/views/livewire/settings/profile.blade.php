<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name, email address and avatar')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6" enctype="multipart/form-data">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                @if ($avatar)
                    <img src="{{ $avatar->temporaryUrl() }}" alt="{{ __('Avatar Preview') }}"
                        class="rounded-full h-20 w-20 object-cover">
                @elseif (auth()->user()->avatar_url)
                    <img src="{{ asset(auth()->user()->avatar_url) }}" alt="{{ __('Current Avatar') }}"
                        class="rounded-full h-20 w-20 object-cover">
                @else
                    <div class="rounded-full h-20 w-20 bg-gray-200 flex items-center justify-center text-gray-500 text-xl">
                        <svg class="h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM12 12C6.477 12 2 7.523 2 2S6.477 0 12 0s10 4.477 10 10-4.477 2-10 2z" />
                        </svg>
                    </div>
                @endif

                <flux:input type="file" wire:model="avatar" label="{{ __('Change Avatar') }}" class="flex-1" />
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>