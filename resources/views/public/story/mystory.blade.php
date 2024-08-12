@extends('public.app')

@section('title', trans('story.mystory'))
@section('canonical', route('public.mystory.index'))
@section('content')
    <main class="">
        <div class="2xl:m-auto 2xl:max-w-screen-2xl">
            <section class="bg-white dark:bg-gray-900 mx-auto md:max-w-4xl">

                <div class="alert alert-danger mx-10 mt-10 text-xl">
                    সতর্কীকরণ : এই গল্পের এক্সেস টি ব্রাউজার কুকি থেকে দেখানো হচ্ছে। যদি কোনো কারনে কুকি রিমুভ হয়ে যায়
                    তাহলে আর আপনি এই গল্পের এক্সেস পাবেন না
                </div>

                <div class="px-10 my-10">
                    <div class="mb-5 border-b border-gray-100">
                        @if ($posts->total())
                            <h1 class="mb-3 text-xl md:text-2xl text-slate-900">
                                আমার গল্প গুলো ({{ $posts->total() }})
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
                            @include('public.story.post.post-loop')
                        @endforeach

                        @if ($posts->hasPages())
                            <div class="pagination-wrapper">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    </div>
                </div>

            </section>
        </div>
    </main>

@endsection
