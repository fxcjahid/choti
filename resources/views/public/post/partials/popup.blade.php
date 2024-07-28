<div id="adsModal"
     tabindex="-1"
     data-modal-placement="top-left"
     aria-hidden="true"
     class="fixed top-0 right-0 left-0 z-50 hidden h-modal w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 md:h-full">
    <div class="relative mx-4 md:m-auto">
        <!-- Modal content -->
        <div
             class="relative h-[280px] w-full overflow-hidden rounded-lg bg-slate-100 shadow dark:bg-gray-800 sm:p-5 md:w-[670px]">
            <button type="button"
                    class="absolute top-2.5 right-2.5 z-20 ml-auto inline-flex items-center rounded-lg p-1.5 text-sm text-gray-700 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                    id="adsModalClose"
                    data-modal-hide="adsModal">
                <svg aria-hidden="true"
                     class="h-5 w-5"
                     fill="currentColor"
                     viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>

            <div class="flex h-full items-center justify-between gap-5">
                <div class="p-5 text-left">
                    <h1 class="mb-4 mt-2 text-2xl font-semibold text-slate-800">
                        Faites-vous face à une infestation de nuisibles ?
                    </h1>
                    <p class="mb-6 mt-2 text-base text-slate-700">
                        Ne restez pas seul dans la bataille contre les
                        nuisibles. Faites appel à un expert !
                    </p>
                    <div
                         class="animate-infinite mt-12 animate-shake cursor-pointer hover:animate-none">
                        <a onclick="window.open('tel:{{ AppHelper::$leadNumber }}', '_self');"
                           class="rounded-lg bg-theme-color px-5 py-3 text-xl font-medium text-white transition-colors hover:animate-none hover:bg-gray-900 focus:outline-none">
                            Appelez-nous
                        </a>
                    </div>
                </div>
                <div class="relative hidden h-full w-3/6 md:block">
                    <div class="h-full w-full">
                        <div class="absolute"></div>
                        <img class="h-full object-cover py-2"
                             src="{{ asset('assets/public/img/inline-man-ads.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
