<div class="hs-dropdown relative inline-flex [--placement:top-left]">
    @php
        $status = Request::get('orderBy');
        switch ($status) {
            case 'name':
                $status = (object) [
                    'name' => 'Alphabetic',
                ];
                break;
            case 'asc':
                $status = (object) [
                    'name' => 'Ascending',
                ];
                break;
            case 'desc':
                $status = (object) [
                    'name' => 'Descending',
                ];
                break;
        
            default:
                $status = (object) [
                    'name' => 'Order By',
                ];
                break;
        }
        $statusHeader = sprintf('%s', $status->name);
    @endphp

    <button id="hs-dropup"
            type="button"
            class="hs-dropdown-toggle inline-flex items-center justify-center gap-2 py-3 px-4 align-middle font-medium text-gray-700 outline-none transition-all dark:text-gray-400 dark:hover:text-white">
        {{ $statusHeader }}
        <svg class="h-3.5 w-3.5 text-gray-600 hs-dropdown-open:rotate-180"
             width="16"
             height="16"
             xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 448 512">
            <path
                  d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z" />
        </svg>
    </button>

    <div class="hs-dropdown-menu duration z-10 hidden w-52 rounded-lg bg-white p-2 opacity-0 shadow-md transition-[opacity,margin] hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border dark:border-gray-700 dark:bg-gray-800"
         aria-labelledby="hs-dropup">

        <a class="flex items-center gap-x-3.5 rounded-md py-2 px-3 text-base text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
           href="{{ request()->fullUrlWithQuery(['orderBy' => 'name']) }}">
            Alphabetic
        </a>

        <a class="flex items-center gap-x-3.5 rounded-md py-2 px-3 text-base text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
           href="{{ request()->fullUrlWithQuery(['orderBy' => 'asc']) }}">
            Ascending
        </a>

        <a class="flex items-center gap-x-3.5 rounded-md py-2 px-3 text-base text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
           href="{{ request()->fullUrlWithQuery(['orderBy' => 'desc']) }}">
            Descending
        </a>
    </div>
</div>
