<x-auth-layout>
    <div class="min-w-full min-h-[calc(100vh-theme('spacing.header'))] flex items-stretch">
        <div class="hidden lg:flex flex-col justify-between w-1/2 p-12 xl:p-16 bg-heading text-white relative overflow-hidden">
            <div class="absolute -top-32 -right-32 size-[28rem] rounded-full bg-primary/30 blur-[120px] pointer-events-none"></div>
            <div class="absolute -bottom-40 -left-20 size-[28rem] rounded-full bg-primary/15 blur-[120px] pointer-events-none"></div>
            <a href="{{ route('home.index') }}" class="relative z-10 inline-flex items-center gap-2 text-2xl font-extrabold tracking-tight">
                <span class="size-10 flex-center rounded-xl bg-primary text-white"><i class="ri-graduation-cap-fill"></i></span>
                {{ translate('ACE Academic') }}
            </a>
            <div class="relative z-10 max-w-md">
                <h2 class="text-4xl xl:text-5xl font-extrabold leading-[1.1] tracking-[-0.02em]">
                    {{ translate('Back to') }}
                    <span class="text-secondary">{{ translate('learning, fast.') }}</span>
                </h2>
                <p class="text-white/70 text-lg leading-relaxed mt-5">
                    {{ translate('Reset your password and pick up right where you left off.') }}
                </p>
            </div>
            <div class="relative z-10 text-white/50 text-sm">© {{ date('Y') }} {{ translate('ACE Academic Coaching') }}</div>
        </div>
        <div class="grow w-full lg:w-1/2 py-12 px-5 lg:p-12 xl:p-16 flex-center flex-col">
            <h2 class="area-title"> {{ !isset($token) ? translate('Reset your') : translate('Update your') }}
                {{ translate('Password') }}</h2>
            <p class="area-description max-w-screen-sm mx-auto text-center mt-5">
                {{ translate('No worries, it happens! Just enter your email, and we will help you unlock your account with a fresh password. Your learning journey is just a step away') }}!
            </p>
            <form action="{{ isset($token) ? route('password.update') : route('forgot.password') }}"
                class="w-full max-w-screen-sm mt-10 form" method="POST">
                @csrf
                @if (isset($token))
                    <input type="hidden" name="token" value="{{ $token }}">
                @endif
                <div class="grid grid-cols-2 gap-x-3 gap-y-5">
                    <div class="col-span-full">
                        <div class="relative">
                            <input type="email" id="user_email" name="email" class="form-input rounded-lg peer"
                                placeholder="" />
                            <label for="user_email" class="form-label floating-form-label">{{ translate('Email') }}
                                <span class="text-danger">*</span></label>
                        </div>
                        <span class="error-text email_err"></span>
                    </div>

                    @if (isset($token))
                        <div class="col-span-full">
                            <div class="relative">
                                <input type="password" id="user_password" name="password"
                                    class="form-input rounded-lg peer" placeholder="" />
                                <label for="user_password"
                                    class="form-label floating-form-label">{{ translate('Password') }} <span
                                        class="text-danger">*</span></label>
                                <!-- type toggler -->
                                <label
                                    class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 focus:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                    <input type="checkbox" class="inputTypeToggle peer/it" hidden>
                                    <i
                                        class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                </label>
                            </div>
                            <span class="error-text password_err"></span>
                        </div>
                        <div class="col-span-full">
                            <div class="relative">
                                <input type="password" id="user_password_confirm" name="password_confirmation"
                                    class="form-input rounded-lg peer" placeholder="" />
                                <label for="user_password"
                                    class="form-label floating-form-label">{{ translate('Confirm Password') }} <span
                                        class="text-danger">*</span></label>
                                <!-- type toggler -->
                                <label
                                    class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 focus:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                    <input type="checkbox" class="inputTypeToggle peer/it" hidden>
                                    <i
                                        class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                </label>
                            </div>
                        </div>
                    @endif
                    <div class="col-span-full">
                        <button type="submit" aria-label="Update password"
                            class="btn b-solid btn-primary-solid btn-xl font-bold w-full h-12">
                            {{ !isset($token) ? translate('Send Request') : translate('Update Password') }}
                        </button>
                    </div>
                </div>
            </form>

            @if (!isset($token))
                <div
                    class="flex-center w-full max-w-screen-sm py-6 h-max relative text-heading dark:text-white font-normal before:absolute inset-0 before:w-full before:h-px before:bg-border">
                    <span class="relative z-10 px-5 bg-white text-sm">{{ translate('OR') }}</span>
                </div>
                <div class="w-full max-w-screen-sm">
                    <a href="{{ route('login') }}" aria-label="Back to login"
                        class="btn b-solid btn-primary-solid btn-xl !rounded-full font-bold w-full h-12">
                        <i class="ri-arrow-left-line"></i>
                        {{ translate('Back to Login') }}
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-auth-layout>
