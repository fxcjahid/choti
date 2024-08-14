@extends('public.account.index')
@section('title', 'আমার সমস্ত গল্প গুলো')
@section('subcontent')
    <div class="profile-edits">
        <div class="mb-5 border-b border-gray-100">
            @if ($posts->total())
                <h1 class="mb-3 text-xl md:text-2xl text-slate-900">
                    আমার সমস্ত গল্প গুলো ({{ $posts->total() }})
                </h1>
            @elseif (!empty($posts))
                <h1 class="mb-3 text-xl md:text-2xl text-slate-900">
                    আপনার কোনো গল্প পাওয়া যায় নেই <a
                        class="rounded-lg md:ml-5 bg-theme-color py-2 px-5 text-center text-base font-medium text-white outline-none hover:bg-theme-light dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit"
                        href="{{ route('public.account.create-story') }}">
                        নতুন গল্প লিখুন
                    </a>
                </h1>
            @endif
        </div>
        <div class="my-10">
            @foreach ($posts as $post)
                @include('public.account.utility.post-loop')
            @endforeach

            @if ($posts->hasPages())
                <div class="pagination-wrapper">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
