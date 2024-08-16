@extends('public.app')

@section('content')
    <main class="">
        <div class="2xl:m-auto 2xl:max-w-screen-2xl">

            <section class="bg-gray-100 py-3 md:py-10">
                <div class="bg-white lg:flex lg:flex-row rounded margin-responsive">
                    <div class="w-full lg:w-[70%]">

                        <div class="px-4 py-4 border-b-2">
                            <h1 class="text-2xl md:text-4xl font-semibold text-slate-900">
                                {{ $category->name }}
                            </h1>
                            <p class="py-2 text-lg text-slate-900">
                                {{ $category->description }}
                            </p>
                        </div>

                        <div class="p-0">
                            @foreach ($category->post as $index => $post)
                                @include('public.post.partials.card')
                            @endforeach
                        </div>

                        @if ($category->post->hasPages())
                            <div class="pagination-wrapper">
                                {{ $category->post->links('public/components/pagination/simple-step') }}
                            </div>
                        @endif
                    </div>

                    <div class="w-full lg:w-[30%] -md:border-t-2 lg:border-l-4 p-2">

                        @include('public.components.search.index')

                        <div class="my-2 px-2">
                            <h2
                                class="ellipsis my-2.5 text-lg font-semibold text-slate-900 hover:text-blue-900 dark:text-white md:text-2xl">
                                আরও গল্প দেখুন
                            </h2>
                            <ul class="my-1 ml-3 list-none">
                                @foreach ($categorylist as $category)
                                    <li class="mb-1.5">
                                        <a href="{{ $category->url() }}"
                                            class="text-slate-800 hover:text-blue-900 text-lg lg:text-xl">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
