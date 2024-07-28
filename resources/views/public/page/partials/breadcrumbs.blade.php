@if (!@empty($breadcrumbs))
    <div class="padding-responsive dark:bg-gray-800">
        <div
             class="container mx-auto flex items-center overflow-y-auto whitespace-nowrap py-5 pl-0 pr-6">

            <a href="{{ route('home') }}"
               class="text-gray-600 dark:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     viewBox="0 0 20 20"
                     fill="currentColor">
                    <path
                          d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
            </a>

            <span class="mx-2 text-gray-500 rtl:-scale-x-100 dark:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     viewBox="0 0 20 20"
                     fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                          clip-rule="evenodd" />
                </svg>
            </span>


            @foreach ($breadcrumbs as $breadcrumb)
                @if (!is_null($breadcrumb['url']) && !$loop->last)
                    <a href="{{ $breadcrumb['url'] }}"
                       class="text-gray-600 hover:underline dark:text-gray-200">
                        {{ $breadcrumb['title'] }}
                    </a>

                    <span class="mx-2 text-gray-500 rtl:-scale-x-100 dark:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <span class="text-gray-900 dark:text-gray-200">
                        {{ $breadcrumb['title'] }}
                    </span>
                @endif
            @endforeach

        </div>
    </div>
@endif
