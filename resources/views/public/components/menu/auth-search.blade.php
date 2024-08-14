<div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']"
    class="absolute inset-x-0 top-20 z-20 min-h-screen w-full bg-white px-6 py-2 transition-all duration-300 ease-in-out dark:bg-gray-800 md:relative md:top-0 md:mt-0 md:flex md:w-auto md:translate-x-0 md:items-center md:bg-transparent md:p-0 md:opacity-100">
    @include('public.components.search.index')
    @includeWhen(auth()->guest(), 'public.components.auth.mobile')
</div>
