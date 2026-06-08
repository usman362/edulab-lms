@php
    $settings = [
        'components' => [
            'inner-header-top' => '',
        ],
    ];
@endphp

<x-auth-layout :data="$settings">

    <div class="min-w-full min-h-[calc(100vh-theme('spacing.header'))] flex items-stretch">
        {{-- LEFT — branded premium panel (no stock illustration) --}}
        <div class="hidden lg:flex flex-col justify-between w-1/2 p-12 xl:p-16 bg-heading text-white relative overflow-hidden">
            <div class="absolute -top-32 -right-32 size-[28rem] rounded-full bg-primary/30 blur-[120px] pointer-events-none"></div>
            <div class="absolute -bottom-40 -left-20 size-[28rem] rounded-full bg-primary/15 blur-[120px] pointer-events-none"></div>

            <a href="{{ route('home.index') }}" class="relative z-10 inline-flex items-center gap-2 text-2xl font-extrabold tracking-tight">
                <span class="size-10 flex-center rounded-xl bg-primary text-white"><i class="ri-graduation-cap-fill"></i></span>
                {{ translate('ACE Academic') }}
            </a>

            <div class="relative z-10 max-w-md">
                <h2 class="text-4xl xl:text-5xl font-extrabold leading-[1.1] tracking-[-0.02em]">
                    {{ translate('Effort to Excellence.') }}
                    <span class="text-secondary">{{ translate("That's how you ACE it.") }}</span>
                </h2>
                <p class="text-white/70 text-lg leading-relaxed mt-5">
                    {{ translate('Expert tutoring for Brisbane students — Selective, NAPLAN, ATAR, Medicine & UCAT preparation.') }}
                </p>
                <div class="flex items-center gap-8 mt-10 pt-8 border-t border-white/15">
                    <div>
                        <div class="text-3xl font-extrabold text-secondary leading-none">99.95</div>
                        <div class="text-xs uppercase tracking-wider text-white/60 mt-1.5">{{ translate('Top ATAR') }}</div>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-secondary leading-none">500+</div>
                        <div class="text-xs uppercase tracking-wider text-white/60 mt-1.5">{{ translate('Families Coached') }}</div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 text-white/50 text-sm">© {{ date('Y') }} {{ translate('ACE Academic Coaching') }}</div>
        </div>

        {{-- RIGHT — clean sign-in --}}
        <div class="grow w-full lg:w-1/2 py-12 px-5 lg:p-12 xl:p-16 flex-center flex-col">
            <div class="w-full max-w-md">
                <h2 class="area-title">{{ translate('Welcome back') }}</h2>
                <p class="area-description mt-3">
                    {{ translate('Sign in to access your ACE learning dashboard.') }}
                </p>

                {{-- Member / Admin toggle (no demo credentials) --}}
                <div class="dashkit-tab inline-flex p-1 bg-gray-100 rounded-full mt-8" id="userRegisterTab">
                    <button type="button" aria-label="Member login"
                        class="dashkit-tab-btn active px-6 py-2.5 rounded-full text-sm font-semibold text-heading [&.active]:bg-white [&.active]:shadow-card custom-transition"
                        data-tab="member">{{ translate('Member') }}</button>
                    <button type="button" aria-label="Admin login"
                        class="dashkit-tab-btn px-6 py-2.5 rounded-full text-sm font-semibold text-heading/60 [&.active]:bg-white [&.active]:shadow-card [&.active]:text-heading custom-transition"
                        data-tab="admin">{{ translate('Admin') }}</button>
                </div>

                <div class="dashkit-tab-content w-full *:hidden" id="userRegisterTabContent">
                    {{-- MEMBER (student / instructor / organisation) --}}
                    <div class="dashkit-tab-pane !block" data-tab="member">
                        <x-theme::form.login-form />
                    </div>

                    {{-- ADMIN --}}
                    <div class="dashkit-tab-pane" data-tab="admin">
                        <form action="{{ route('admin.login') }}" class="w-full mt-8 form" method="POST">
                            @csrf
                            <div class="grid grid-cols-2 gap-x-3 gap-y-5">
                                <div class="col-span-full">
                                    <div class="relative">
                                        <input type="email" name="email" id="admin-email" class="form-input rounded-lg peer" placeholder="" required />
                                        <label for="admin-email" class="form-label floating-form-label">{{ translate('Email') }} <span class="text-danger">*</span></label>
                                    </div>
                                    <span class="error-text content_err"></span>
                                </div>
                                <div class="col-span-full">
                                    <div class="relative">
                                        <input type="password" name="password" id="admin-password" class="form-input rounded-lg peer" placeholder="" required />
                                        <label for="admin-password" class="form-label floating-form-label">{{ translate('Password') }} <span class="text-danger">*</span></label>
                                        <label class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                            <input type="checkbox" class="inputTypeToggle peer/it" hidden>
                                            <i class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                        </label>
                                    </div>
                                    <span class="error-text content_err"></span>
                                </div>
                                <div class="col-span-full">
                                    <button type="submit" aria-label="Admin login"
                                        class="btn b-solid btn-primary-solid btn-xl font-bold w-full h-12">
                                        {{ translate('Log in') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="flex-center w-full py-6 h-max relative text-heading dark:text-white font-normal before:absolute inset-0 before:w-full before:h-px before:bg-border">
                    <span class="relative z-10 px-5 bg-white dark:bg-dark-card text-sm text-heading/60">{{ translate('OR') }}</span>
                </div>
                <div class="text-heading dark:text-white text-center text-sm">
                    {{ translate("Don't have an account yet?") }}
                    <a href="{{ route('register.page') }}" class="text-primary hover:underline font-semibold" aria-label="Sign up page">{{ translate('Sign up') }}</a>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            // Clean Member/Admin tab toggle — no pre-filled credentials.
            $(document).on('click', '#userRegisterTab .dashkit-tab-btn', function () {
                var tab = $(this).data('tab');
                $('#userRegisterTab .dashkit-tab-btn').removeClass('active');
                $(this).addClass('active');
                $('#userRegisterTabContent .dashkit-tab-pane').removeClass('!block').hide();
                $('#userRegisterTabContent .dashkit-tab-pane[data-tab="' + tab + '"]').addClass('!block').show();
            });
        </script>
    @endpush
</x-auth-layout>
