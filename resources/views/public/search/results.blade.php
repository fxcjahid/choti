<div class="bg-slate-50 p-4 rounded-lg shadow">
    <div class="flex items-center">
        <h2 class="text-xl font-medium text-blue-700 hover:text-blue-900 flex-1">
            <a href="{{ $result->url() }}">
                {!! $result->title !!}
            </a>
        </h2>
        <a href="{{ $result->url() }}" class="text-blue-800 hover:text-blue-900 ml-2">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
    <p class="text-gray-700 mt-2 ellipsis line-clamp-4">
        {!! $result->content !!}
    </p>
</div>
