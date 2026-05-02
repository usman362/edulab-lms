<div id="offcanvas-menu" class="bg-black/50 fixed size-full inset-0 invisible opacity-0 duration-300 z-[102]">
    <div class="offcanvas-menu-inner absolute top-0 bottom-0 right-0 rtl:right-auto rtl:left-0 flex flex-col py-4 bg-white w-64 sm:w-72 translate-x-full rtl:-translate-x-full duration-300 z-[103]">
        <!-- CLOSE MENU -->
        <button type="button" class="offcanvas-menu-close size-11 flex-center bg-white border border-transparent hover:border-primary absolute top-4 right-full rtl:right-auto rtl:left-full custom-transition">
            <i class="ri-close-line text-gray-500 dark:text-dark-text"></i>
        </button>
        <!-- header search -->
        <div class="px-4 pr-6 xl:pr-4">
            <x-theme::header.search />
        </div>
        <!-- Online Platform Button (mobile) -->
        <div class="px-4 mt-3">
            <a href="{{ url('/page/online-platform') }}" aria-label="Online Platform"
                class="flex items-center justify-center gap-2 w-full py-2.5 rounded-full bg-primary text-white font-semibold text-sm shadow-md">
                <i class="ri-computer-line"></i>
                {{ translate('Online Platform') }}
            </a>
        </div>
        <div class="my-5 px-4 overflow-x-hidden grow">
            <ul class="leading-none text-heading dark:text-white font-medium">
                <li>
                    <button onclick="let sub=this.nextElementSibling;let icon=this.querySelector('i');sub.classList.toggle('hidden');icon.classList.toggle('rotate-180');" class="flex items-center justify-between w-full py-3 hover:text-primary custom-transition">
                        <span>{{ translate('Programs') }}</span>
                        <i class="ri-arrow-down-s-line transition-transform duration-200"></i>
                    </button>
                    <ul class="hidden pl-4 border-l border-gray-200">
                        <li>
                            <a href="{{ route('category.course', 'tutoring-for-year-5-12') }}" class="inline-block w-full py-2 text-sm hover:text-primary custom-transition">
                                {{ translate('Tutoring for Year 5-12') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('category.course', 'acceleration-class') }}" class="inline-block w-full py-2 text-sm hover:text-primary custom-transition">
                                {{ translate('Acceleration Class') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('category.course', 'ucat-excellence') }}" class="inline-block w-full py-2 text-sm hover:text-primary custom-transition">
                                {{ translate('UCAT Excellence') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('category.course', 'selective-exam-preparation') }}" class="inline-block w-full py-2 text-sm hover:text-primary custom-transition">
                                {{ translate('Selective Exam Preparation') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('course.list') }}" class="inline-block w-full py-2 text-sm hover:text-primary custom-transition font-semibold">
                                {{ translate('View All Programs') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('about.us') }}" aria-label="Menu link" class="inline-block w-full py-3 hover:text-primary [&.active]:text-primary custom-transition">
                        {{ translate('About') }}
                    </a>
                </li>
                <li>
                    <a href="{{ url('/page/free-resources') }}" aria-label="Menu link" class="inline-block w-full py-3 hover:text-primary [&.active]:text-primary custom-transition">
                        {{ translate('Free Resources') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact.page') }}" aria-label="Menu link" class="inline-block w-full py-3 hover:text-primary [&.active]:text-primary custom-transition">
                        {{ translate('Contact') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('register.page') }}?user_type=instructor" aria-label="Become a Tutor" class="inline-block w-full py-3 text-primary font-semibold hover:text-primary/80 custom-transition">
                        <i class="ri-user-add-line mr-1"></i> {{ translate('Become a Tutor') }}
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>
