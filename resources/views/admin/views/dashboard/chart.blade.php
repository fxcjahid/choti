<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="text-left">
            <h1 class="text-3xl text-slate-900 font-bold">45,385</h1>
            <p class="text-sm text-gray-500">Visitor this week</p>
        </div>

        <div class="">
            <div>
                <button
                    class="inline-flex items-center gap-2 p-2 text-sm font-medium text-center text-gray-600 rounded-lg hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                    type="button" data-dropdown-toggle="weekly-sales-dropdown">
                    Last 7 days <i class="fas fa-chevron-down text-gray-600"></i>
                </button>

                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="weekly-sales-dropdown" data-popper-placement="bottom">
                    <ul class="py-1" role="dropdownitem">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                role="menuitem">Yesterday</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                role="menuitem">Today</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                role="menuitem">Last 7 days</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                role="menuitem">Last 30 days</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                role="menuitem">Last 90 days</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="my-2">
        <canvas id="salesChart" class="w-full h-10"></canvas>
    </div>
</div>
