<header x-data="{ isOpen: false }" class="top-header relative bg-white shadow dark:bg-gray-800">
    <div class="m-auto">
        <div class="margin-responsive flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex w-full items-center justify-between">

                <!-- Band Logo --->
                <div class="flex w-auto items-center">
                    <a href="{{ route('home') }}" class="hover:animate-pulse">
                        <img class="w-56 md:w-80 py-6" src="{{ asset('assets/public/img/all-bangla-choti.png') }}" />
                    </a>
                </div>

                <!-- Search input on desktop screen -->
                <div class="flex items-center gap-x-10">
                    <div class="relative hidden md:block">
                        <form action="{{ route('search.index') }}" method="GET">
                            <span class="absolute inset-y-0 left-0 flex cursor-pointer items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                    </path>
                                </svg>
                            </span>

                            <input type="text" name="query"
                                class="w-52 rounded-md border border-gray-200 bg-white py-2 pl-10 pr-4 text-gray-700 outline-none transition-all focus:w-[450px] dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                                placeholder="গল্প সার্চ করুন...">
                        </form>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button x-cloak x-on:click="isOpen = !isOpen" type="button"
                            class="text-gray-500 hover:text-gray-600 focus:text-gray-600 focus:outline-none dark:text-gray-200 dark:hover:text-gray-400 dark:focus:text-gray-400"
                            aria-label="toggle menu">
                            <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                            </svg>

                            <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    @auth
                        <div class="hidden relative md:block">
                            <a href="{{ route('public.account.index') }}"
                                class="inline-flex cursor-pointer items-center gap-1.5 rounded-full bg-theme-color py-2.5 px-3 text-base font-medium text-white transition-all duration-700 hover:bg-theme-light">
                                {{ trans('account.title') }}
                            </a>
                        </div>
                    @endauth
                    @guest
                        <div class="hidden relative md:block">
                            <a href="{{ route('public.auth.index') }}"
                                class="inline-flex cursor-pointer items-center gap-1.5 rounded-full bg-theme-color py-2.5 px-3 text-base font-medium text-white transition-all duration-700 hover:bg-theme-light">
                                লগইন | সাইনআপ
                            </a>
                        </div>
                    @endguest
                </div>

            </div>

            @includeWhen(Agent::isMobile(), 'public.components.menu.auth-search')

        </div>

        <!-- categories menu -->
        <div
            class="scroll-hidden overflow-y-auto whitespace-nowrap border-b-4 border-solid border-b-blue-900 bg-theme-color py-3 sm:mt-3">
            <div class="margin-responsive h-c-menu">
                <a class="mx-4 transform text-xl leading-5 text-white hover:text-blue-600 transition-colors duration-300 dark:text-gray-200"
                    href="{{ route('home') }}">
                    হোমপেজ
                </a>
                <a class="mx-4 transform text-xl leading-5 text-white hover:text-blue-600 transition-colors duration-300 dark:text-gray-200"
                    href="#">
                    জনপ্রিয় গল্প
                </a>
                <a class="mx-4 transform text-xl leading-5 text-white hover:text-blue-600 transition-colors duration-300 dark:text-gray-200"
                    href="{{ route('search.index') }}">
                    সার্চ করুন
                </a>
                <a class="mx-4 transform text-xl leading-5 text-white hover:text-blue-600 transition-colors duration-300 dark:text-gray-200"
                    href="{{ route('public.story.index') }}">
                    গল্প লিখে পাঠান
                </a>

                @if (request()->cookie('post'))
                    <a class="mx-4 transform text-xl leading-5 text-white hover:text-blue-600 transition-colors duration-300 dark:text-gray-200"
                        href="{{ route('public.mystory.index') }}">
                        আমার গল্প
                    </a>
                @endif

                <div class="hs-dropdown relative inline-flex [--trigger:hover]">
                    <button id="hs-dropdown-hover-event" type="button"
                        class="hs-dropdown-toggle mx-4 flex transform items-center gap-1 text-xl leading-5 text-white transition-colors duration-300 dark:text-gray-200">
                        আরো দেখুন
                    </button>

                    <svg class="mt-1.5 h-3 w-3 text-white transition-all duration-500 hs-dropdown-open:rotate-180"
                        viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>

                    <div
                        class="hs-dropdown-menu duration-[0.1ms] sm:duration-[150ms] text-lg -md:!right-5 top-full z-10 hidden -md:w-[90%] rounded-md shadow-xl md:w-auto bg-white p-2 opacity-0 transition-[opacity,margin] before:absolute before:-top-5 before:left-0 before:h-5 before:w-full hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-800 sm:w-36 sm:rounded-lg sm:border sm:shadow-md sm:dark:border">

                        <div
                            class="hs-dropdown relative -md:border-b -md:border-slate-200 [--strategy:static] [--adaptive:none] sm:[--strategy:absolute] sm:[--trigger:hover]">
                            <a class="flex items-center gap-x-3.5 rounded-md py-2 px-3 text-gray-800 hover:text-blue-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                href="{{ route('contact.index') }}">
                                যোগাযোগ করুন
                            </a>
                        </div>
                        <div
                            class="hs-dropdown relative [--strategy:static] [--adaptive:none] sm:[--strategy:absolute] sm:[--trigger:hover]">
                            <a class="flex items-center gap-x-3.5 rounded-md py-2 px-3 text-gray-800 hover:text-blue-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                href="{{ route('complain.index') }}">
                                অভিযোগ জানান
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</header>
