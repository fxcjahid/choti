<header x-data="{ isOpen: false }" class="top-header relative bg-white shadow dark:bg-gray-800">
    <div class="m-auto">
        <div class="margin-responsive flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex w-full items-center justify-between">

                <!-- Mobile menu button -->
                <div class="hidden">
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

                <!-- Band Logo --->
                <div class="flex w-auto items-center">
                    <a href="{{ route('home') }}" class="hover:animate-pulse">
                        <img class="w-44 py-6" src="{{ asset('assets/public/img/blanee-logo.png') }}" />
                    </a>
                </div>

                <!-- Search input on desktop screen -->
                <div class="flex items-center gap-x-10">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex cursor-pointer items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                            </svg>
                        </span>

                        <input type="text"
                            class="w-52 rounded-md border bg-white py-2 pl-10 pr-4 text-gray-700 outline-none transition-all focus:w-[450px] dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                            placeholder="Search...">
                    </div>
                    <div class="relative">
                        <a href="https://evomart.com.bd/login"
                            class="inline-flex cursor-pointer items-center gap-1.5 rounded-full bg-theme-color py-1.5 px-3 text-sm font-medium text-white transition-all duration-700 hover:bg-theme-light">
                            Login / Singup
                        </a>
                    </div>
                </div>

            </div>

            <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
            <div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']"
                class="absolute inset-x-0 top-20 z-20 w-full bg-white px-6 py-2 transition-all duration-300 ease-in-out dark:bg-gray-800 md:relative md:top-0 md:mt-0 md:flex md:w-auto md:translate-x-0 md:items-center md:bg-transparent md:p-0 md:opacity-100">

                <!-- Search input on mobile screen -->
                <div class="my-4 md:hidden">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                            </svg>
                        </span>

                        <input type="text"
                            class="w-full rounded-md border bg-white py-2 pl-10 pr-4 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:focus:border-blue-300"
                            placeholder="Search">
                    </div>
                </div>
            </div>
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
                    href="{{ route('guides-nuisibles') }}">
                    জনপ্রিয় গল্প
                </a>
                <a class="mx-4 transform text-xl leading-5 text-white hover:text-blue-600 transition-colors duration-300 dark:text-gray-200"
                    href="{{ AppHelper::$leadFormLink }}" target="_blank">
                    জনপ্রিয় লেখক
                </a>
                <a class="mx-4 transform text-xl leading-5 text-white hover:text-blue-600 transition-colors duration-300 dark:text-gray-200"
                    href="{{ route('category', ['category' => 'prix']) }}">
                    গল্প লিখে পাঠান
                </a>

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
                        class="hs-dropdown-menu duration-[0.1ms] sm:duration-[150ms] top-full z-10 hidden w-full bg-white p-2 opacity-0 transition-[opacity,margin] before:absolute before:-top-5 before:left-0 before:h-5 before:w-full hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-800 sm:w-72 sm:rounded-lg sm:border sm:shadow-md sm:dark:border">

                        <div
                            class="hs-dropdown relative [--strategy:static] [--adaptive:none] sm:[--strategy:absolute] sm:[--trigger:hover]">
                            <a class="flex items-center gap-x-3.5 rounded-md py-2 px-3 text-gray-800 hover:text-blue-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                href="https://serruriergenial.com/?source=blanee">
                                যোগাযোগ করুন
                            </a>
                        </div>
                        <div
                            class="hs-dropdown relative [--strategy:static] [--adaptive:none] sm:[--strategy:absolute] sm:[--trigger:hover]">
                            <a class="flex items-center gap-x-3.5 rounded-md py-2 px-3 text-gray-800 hover:text-blue-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                href="https://jardiniergenial.com/?source=blanee">
                                অভিযোগ জানান
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</header>
