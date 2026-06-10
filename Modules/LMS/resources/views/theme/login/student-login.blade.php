@php
    $settings = [
        'components' => [
            'inner-header-top' => '',
        ],
    ];
@endphp

<x-auth-layout :data="$settings" :hide-header="true">

    <div class="min-w-full min-h-screen flex items-stretch">
        {{-- LEFT — branded premium panel --}}
        <div class="hidden lg:flex flex-col justify-between w-1/2 p-12 xl:p-16 bg-heading text-white relative overflow-hidden">
            <div class="absolute -top-32 -right-32 size-[28rem] rounded-full bg-primary/30 blur-[120px] pointer-events-none"></div>
            <div class="absolute -bottom-40 -left-20 size-[28rem] rounded-full bg-primary/15 blur-[120px] pointer-events-none"></div>

            <a href="{{ route('home.index') }}" class="relative z-10 inline-flex items-center gap-2 text-2xl font-extrabold tracking-tight">
                <span class="size-10 flex-center rounded-xl bg-primary text-white"><i class="ri-graduation-cap-fill"></i></span>
                {{ translate('ACE Academic') }}
            </a>

            <div class="relative z-10 max-w-md">
                <h2 class="text-4xl xl:text-5xl font-extrabold leading-[1.1] tracking-[-0.02em]">
                    {{ translate('Your online') }}
                    <span class="text-secondary">{{ translate('learning platform.') }}</span>
                </h2>
                <p class="text-white/70 text-lg leading-relaxed mt-5">
                    {{ translate('Sign in to access your courses, lessons and resources — anytime, anywhere.') }}
                </p>
                <div class="flex items-center gap-8 mt-10 pt-8 border-t border-white/15">
                    <div>
                        <div class="text-3xl font-extrabold text-secondary leading-none">99.95</div>
                        <div class="text-xs uppercase tracking-wider text-white/60 mt-1.5">{{ translate('Top ATAR') }}</div>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-secondary leading-none">500+</div>
                        <div class="text-xs uppercase tracking-wider text-white/60 mt-1.5">{{ translate('Students') }}</div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 text-white/50 text-sm">© {{ date('Y') }} {{ translate('ACE Academic Coaching') }}</div>
        </div>

        {{-- RIGHT — student-only sign-in (no role selection) --}}
        <div class="grow w-full lg:w-1/2 py-12 px-5 lg:p-12 xl:p-16 flex-center flex-col">
            <div class="w-full max-w-md">
                <h2 class="area-title">{{ translate('Student Login') }}</h2>
                <p class="area-description mt-3">
                    {{ translate('Welcome back! Sign in to continue learning.') }}
                </p>

                <form action="{{ route('auth.login') }}" class="w-full mt-8 form" method="POST">
                    @csrf
                    <input type="hidden" name="user_type" value="student">
                    <div class="grid grid-cols-1 gap-y-5">
                        <div>
                            <div class="relative">
                                <input type="email" name="email" id="student_email" class="form-input rounded-lg peer" placeholder="" required />
                                <label for="student_email" class="form-label floating-form-label">{{ translate('Email') }} <span class="text-danger">*</span></label>
                            </div>
                            <span class="error-text email_err"></span>
                        </div>
                        <div>
                            <div class="relative">
                                <input type="password" name="password" id="student_password" class="form-input rounded-lg peer" placeholder="" required />
                                <label for="student_password" class="form-label floating-form-label">{{ translate('Password') }} <span class="text-danger">*</span></label>
                                <label class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                    <input type="checkbox" class="inputTypeToggle peer/it" hidden>
                                    <i class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                </label>
                            </div>
                            <span class="error-text password_err"></span>
                        </div>
                        <div class="flex-center-between px-1">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" name="remember_me" class="checkbox checkbox-primary rounded-sm">
                                <span class="text-heading dark:text-white font-medium leading-none text-sm">{{ translate('Remember me') }}</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-primary hover:underline text-sm font-medium">{{ translate('Forgot Password?') }}</a>
                        </div>
                        <button type="submit" aria-label="Student login"
                            class="btn b-solid btn-primary-solid btn-xl font-bold w-full h-12">
                            {{ translate('Log in') }}
                        </button>
                    </div>
                </form>

                <div class="flex-center w-full py-6 h-max relative text-heading dark:text-white font-normal before:absolute inset-0 before:w-full before:h-px before:bg-border">
                    <span class="relative z-10 px-5 bg-white dark:bg-dark-card text-sm text-heading/60">{{ translate('OR') }}</span>
                </div>

                <a href="{{ route('register.page') }}?user_type=student" aria-label="Create student account"
                    class="btn b-outline btn-primary-outline btn-xl font-bold w-full h-12">
                    {{ translate('Sign up') }}
                </a>

                <p class="text-center text-xs text-heading/50 mt-5">
                    {{ translate('New accounts are reviewed and approved before access is granted.') }}
                </p>
            </div>
        </div>
    </div>
</x-auth-layout>
