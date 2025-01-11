<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Visitors Card -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between">
                <h2 class="text-3xl text-slate-900 font-bold">
                    {{ $postViews }}
                </h2>
                <p class="text-base font-semibold text-green-500">14.6%</p>
            </div>
            <div class="flex justify-between mt-1.5">
                <p class="text-sm text-gray-600">New visitors this week</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-5 h-20 w-20 text-blue-500" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Posts Card -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between">
                <h2 class="text-3xl text-slate-900 font-bold">2,340</h2>
                <p class="text-base font-semibold text-green-500">14.6%</p>
            </div>
            <div class="flex justify-between mt-1.5">
                <p class="text-sm text-gray-600">New posts this week</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-5 h-20 w-20 text-purple-600" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <path d="M14 2v6h6"></path>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <line x1="10" y1="9" x2="8" y2="9"></line>
                </svg>
            </div>
        </div>
    </div>

    <!-- Signups Card -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between">
                <h2 class="text-3xl text-slate-900 font-bold">40</h2>
                <p class="text-base font-semibold text-red-500">1.6%</p>
            </div>
            <div class="flex justify-between mt-1.5">
                <p class="text-sm text-gray-600">User signups this week</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-5 h-20 w-20 text-orange-400" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
            </div>
        </div>
    </div>
</div>
