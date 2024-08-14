@extends('public.app')

@section('title', 'Blanee : votre allié contre les nuisibles')
@section('canonical', route('home'))
@section('content')
    <!-- page content start -->
    <main class="">
        <div class="2xl:m-auto 2xl:max-w-screen-2xl">

            <!-- block -->
            <section class="bg-gray-100 py-5 md:py-10">
                <div class="bg-white lg:flex lg:flex-row margin-responsive">
                    <div class="w-full lg:w-9/12">
                        <div class="p-0">
                            @foreach ($posts as $index => $post)
                                @include('public.post.partials.card')
                            @endforeach
                        </div>
                        @if ($posts->hasPages())
                            <div class="pagination-wrapper">
                                {{ $posts->links('public/components/pagination/simple-step') }}
                            </div>
                        @endif
                    </div>

                    <div class="w-full lg:w-3/12 -md:border-t-2 lg:border-l-4 lg:border-gray100 p-2">

                        @include('public.components.search.index')

                        <div class="-md:mt-7 my-2 px-2">
                            <h2
                                class="ellipsis my-2.5 text-lg font-semibold text-slate-900 hover:text-blue-900 dark:text-white md:text-2xl">
                                আরও গল্প দেখুন
                            </h2>
                            <ul class="my-1 ml-3 list-none">
                                @foreach ($category as $category)
                                    <li class="mb-1.5">
                                        <a href="{{ $category->url() }}"
                                            class="text-slate-800 hover:text-blue-900 text-lg lg:text-xl">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <img class="mt-10 mx-auto rounded max-h-[488px]" src="https://placehold.co/350x670">
                    </div>
                </div>
            </section>
        </div>
    </main>

@endsection
