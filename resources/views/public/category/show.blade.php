@extends('public.app')

@php
    $seoTitle = "Élimination $category->name - Blanee.com";
@endphp

@section('title', $category->name . ' - Blanee.com')
@section('canonical', route('category', ['category' => $category->slug]))

@section('content')
    <main class="">
        <div class="2xl:m-auto 2xl:max-w-screen-2xl">

            <section class="bg-gray-100 py-5 md:py-10">
                <div class="bg-white lg:flex lg:flex-row margin-responsive">
                    <div class="w-full md:w-[70%]">

                        <div class="mx-5 border-b border-gray-200">
                            <h1 class="mt-8 font-semibold text-4xl text-slate-900">
                                {{ $category->name }}
                            </h1>

                            <div class="relative text-left">
                                <p class="my-3 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                                    {{ $category->description }}
                                </p>
                            </div>
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

                    <div class="w-full md:w-[30%] lg:border-l-4 lg:border-gray100 p-2">

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
