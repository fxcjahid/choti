@extends('public.app')

@section('title', $post->title)
@section('canonical',
    route('post.show', [
    'category' => $post->category[0]->slug,
    'slug' => $post->slug,
    ]))
@section('content')
    <section role="content">

        <!-- breadcrums -->
        @include('public.post.utility.breadcrumbs', [
            'breadcrumbs' => $breadcrumb,
        ])

        <div class="padding-responsive bg-gray-100 md:pb-10 dark:bg-gray-800 2xl:m-auto 2xl:max-w-screen-2xl">

            <!-- block -->

            <div class="flex flex-row md:rounded bg-white dark:bg-slate-900 md:pt-9">
                <!-- content -->
                <article class="w-full md:w-[70%]" aria-label="content" role="article">

                    <div class="px-3 sm:px-7">
                        <h1 role="title" aria-label="title"
                            class="mt-6 text-2xl font-semibold !leading-normal text-gray-800 dark:text-white md:mt-1 md:text-4xl">
                            {{ $post->title }}
                        </h1>

                        <div class="mt-4 items-center">
                            <p class="text-base text-gray-500 dark:text-gray-400">
                                লেখোক :
                                <span role="author">{{ $post->author }}</span> |
                                <span role=datetime>{{ $post->created_at->format('j F Y') }}</span>
                            </p>
                        </div>
                    </div>


                    <div aria-label="content" role="content" class="art-content -md:mt-5 px-3 sm:mt-9 sm:px-7">
                        {!! $post->content !!}
                    </div>

                    <!--- Post nagivation button -->
                    <div class="pagination-wrapper">
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
                            @if ($post->previous())
                                <a href="{{ $post->previous()->url() }}" rel="next"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-blue-700 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    আগের পোস্ট দেখুন
                                </a>
                            @endif

                            @if ($post->next())
                                <a href="{{ $post->next()->url() }}" rel="next"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-blue-700 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    পরবর্তী পোস্ট দেখুন
                                </a>
                            @endif
                        </nav>
                    </div>

                    <!-- Post Tag items -->
                    <div class="px-7 md:mt-5">
                        <div class="flex justify-start gap-2">
                            @foreach ($post->tag as $tag)
                                <a href="{{ route('tag', ['tag' => $tag->slug]) }}" title="{{ $tag->name }}"
                                    class="inline-flex cursor-pointer items-center gap-1.5 rounded-full bg-blue-500 py-1.5 px-3 text-sm font-medium text-white transition-all duration-700 hover:bg-blue-900">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- series wise post suggest -->
                    @if ($post->series->count() >= 1)
                        <section class="my-2 sm:my-5 sm:mt-9">
                            <div class="mx-4 md:mx-8 px-5 pt-2 pb-1 rounded-md bg-gray-100">
                                <h2 class="mt-4 mb-4 text-2xl font-semibold text-slate-900">
                                    এই গল্পের আরও সিরিজ পড়ুন
                                </h2>
                                @foreach ($post->series[0]->post as $post)
                                    @include('public.post.partials.series', $post)
                                @endforeach
                            </div>
                        </section>
                    @endif


                    <!-- Related others post -->
                    @if ($post->suggestion()->count() >= 1)
                        <section class="my-2 sm:my-5 sm:mt-12">
                            <div class="px-3 sm:px-7">
                                <h2 class="mt-4 mb-6 text-2xl md:text-3xl font-semibold text-slate-900">
                                    এই রকমের গল্প আরও পড়ুন
                                </h2>
                                @foreach ($post->suggestion() as $post)
                                    @include('public.post.partials.related', $post)
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <!-- comment section -->
                    <section class="hidden" aria-label="comment"
                        class="sm:padding-responsive bg-slate-100 py-8 dark:bg-gray-900">
                        <div class="mx-auto px-4">
                            <div class="mb-6 flex items-center justify-between">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white lg:text-2xl">
                                    Comments (20)
                                </h2>
                            </div>
                            <form class="mb-6">
                                <div
                                    class="mb-4 rounded-lg rounded-t-lg border border-gray-200 bg-white py-2 px-4 dark:border-gray-700 dark:bg-gray-800">
                                    <label for="comment" class="sr-only">
                                        Your comment
                                    </label>
                                    <textarea id="comment" rows="6"
                                        class="w-full border-0 px-0 text-sm text-gray-900 focus:outline-none focus:ring-0 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Write a comment..." required></textarea>
                                </div>
                                <button type="submit"
                                    class="inline-flex items-center rounded-lg bg-theme-color py-2.5 px-4 text-center text-xs font-medium text-white hover:bg-theme-light">
                                    Post comment
                                </button>
                            </form>
                            <article class="mb-6 rounded-lg bg-white p-6 text-base dark:bg-gray-900">
                                <div class="flex">
                                    <div class="my-auto mr-4">
                                        <div
                                            class="flex w-9 flex-col items-center justify-center rounded bg-gray-100 font-medium">
                                            <button type="button" class="w-full rounded-t border-b py-1 hover:bg-gray-300">
                                                +
                                            </button>
                                            <span class="py-1 text-black">
                                                14
                                            </span>
                                            <button type="button" class="w-full rounded-b border-t py-1 hover:bg-gray-300">
                                                -
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="mb-2 flex items-center justify-between">
                                            <div class="flex items-center">
                                                <p
                                                    class="mr-3 inline-flex items-center text-sm text-gray-900 dark:text-white">
                                                    <img class="mr-2 h-6 w-6 rounded-full"
                                                        src="https://flowbite.com/docs/images/people/profile-picture-2.jpg"
                                                        alt="Michael Gough">Michael Gough
                                                </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    <time pubdate datetime="2022-02-08" title="February 8th, 2022">Feb. 8,
                                                        2022</time>
                                                </p>
                                            </div>
                                            <button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
                                                class="inline-flex items-center rounded-lg bg-white p-2 text-center text-sm font-medium text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                                type="button">
                                                <svg class="h-5 w-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                                    </path>
                                                </svg>
                                                <span class="sr-only">Comment
                                                    settings</span>
                                            </button>
                                            <!-- Dropdown menu -->
                                            <div id="dropdownComment1"
                                                class="z-10 hidden w-36 divide-y divide-gray-100 rounded bg-white shadow dark:divide-gray-600 dark:bg-gray-700">
                                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="dropdownMenuIconHorizontalButton">
                                                    <li>
                                                        <a href="#"
                                                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="#"
                                                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                                    </li>
                                                    <li>
                                                        <a href="#"
                                                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400">Very
                                            straight-to-point article. Really worth time
                                            reading.
                                            Thank you! But tools are just the
                                            instruments for the UX designers. The
                                            knowledge of the
                                            design tools are as important as the
                                            creation of the design strategy.</p>
                                        <div class="mt-4 flex items-center space-x-4">
                                            <button type="button"
                                                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                                                <svg aria-hidden="true" class="mr-1 h-4 w-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                    </path>
                                                </svg>
                                                Reply
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </article>
                            <article class="mb-6 ml-6 rounded-lg bg-white p-6 text-base dark:bg-gray-900 lg:ml-12">
                                <footer class="mb-2 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <p class="mr-3 inline-flex items-center text-sm text-gray-900 dark:text-white">
                                            <img class="mr-2 h-6 w-6 rounded-full"
                                                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                                alt="Jese Leos">Jese Leos
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <time pubdate datetime="2022-02-12" title="February 12th, 2022">Feb. 12,
                                                2022</time>
                                        </p>
                                    </div>
                                    <button id="dropdownComment2Button" data-dropdown-toggle="dropdownComment2"
                                        class="inline-flex items-center rounded-lg bg-white p-2 text-center text-sm font-medium text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                        type="button">
                                        <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                            </path>
                                        </svg>
                                        <span class="sr-only">Comment settings</span>
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div id="dropdownComment2"
                                        class="z-10 hidden w-36 divide-y divide-gray-100 rounded bg-white shadow dark:divide-gray-600 dark:bg-gray-700">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            aria-labelledby="dropdownMenuIconHorizontalButton">
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                            </li>
                                        </ul>
                                    </div>
                                </footer>
                                <p class="text-gray-500 dark:text-gray-400">Much
                                    appreciated! Glad you liked it ☺️</p>
                                <div class="mt-4 flex items-center space-x-4">
                                    <button type="button"
                                        class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                                        <svg aria-hidden="true" class="mr-1 h-4 w-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        Reply
                                    </button>
                                </div>
                            </article>
                            <article class="mb-6 rounded-lg bg-white p-6 text-base dark:border-gray-700 dark:bg-gray-900">
                                <footer class="mb-2 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <p class="mr-3 inline-flex items-center text-sm text-gray-900 dark:text-white">
                                            <img class="mr-2 h-6 w-6 rounded-full"
                                                src="https://flowbite.com/docs/images/people/profile-picture-3.jpg"
                                                alt="Bonnie Green">Bonnie Green
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <time pubdate datetime="2022-03-12" title="March 12th, 2022">Mar. 12,
                                                2022</time>
                                        </p>
                                    </div>
                                    <button id="dropdownComment3Button" data-dropdown-toggle="dropdownComment3"
                                        class="inline-flex items-center rounded-lg bg-white p-2 text-center text-sm font-medium text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                        type="button">
                                        <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                            </path>
                                        </svg>
                                        <span class="sr-only">Comment settings</span>
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div id="dropdownComment3"
                                        class="z-10 hidden w-36 divide-y divide-gray-100 rounded bg-white shadow dark:divide-gray-600 dark:bg-gray-700">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            aria-labelledby="dropdownMenuIconHorizontalButton">
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                            </li>
                                        </ul>
                                    </div>
                                </footer>
                                <p class="text-gray-500 dark:text-gray-400">The article
                                    covers the essentials, challenges, myths and stages
                                    the UX designer should consider while creating the
                                    design strategy.</p>
                                <div class="mt-4 flex items-center space-x-4">
                                    <button type="button"
                                        class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                                        <svg aria-hidden="true" class="mr-1 h-4 w-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        Reply
                                    </button>
                                </div>
                            </article>
                            <article class="rounded-lg bg-white p-6 text-base dark:border-gray-700 dark:bg-gray-900">
                                <footer class="mb-2 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <p class="mr-3 inline-flex items-center text-sm text-gray-900 dark:text-white">
                                            <img class="mr-2 h-6 w-6 rounded-full"
                                                src="https://flowbite.com/docs/images/people/profile-picture-4.jpg"
                                                alt="Helene Engels">Helene Engels
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <time pubdate datetime="2022-06-23" title="June 23rd, 2022">Jun. 23,
                                                2022</time>
                                        </p>
                                    </div>
                                    <button id="dropdownComment4Button" data-dropdown-toggle="dropdownComment4"
                                        class="inline-flex items-center rounded-lg bg-white p-2 text-center text-sm font-medium text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                        type="button">
                                        <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                            </path>
                                        </svg>
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div id="dropdownComment4"
                                        class="z-10 hidden w-36 divide-y divide-gray-100 rounded bg-white shadow dark:divide-gray-600 dark:bg-gray-700">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            aria-labelledby="dropdownMenuIconHorizontalButton">
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                            </li>
                                        </ul>
                                    </div>
                                </footer>
                                <p class="text-gray-500 dark:text-gray-400">Thanks for
                                    sharing this. I do came from the Backend development
                                    and explored some of the tools to design my Side
                                    Projects.</p>
                                <div class="mt-4 flex items-center space-x-4">
                                    <button type="button"
                                        class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                                        <svg aria-hidden="true" class="mr-1 h-4 w-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        Reply
                                    </button>
                                </div>
                            </article>
                        </div>
                    </section>

                </article>

                <!-- sidebar -->
                <aside class="hidden w-full border-l border-solid border-l-gray-100 md:block md:w-[30%]">

                    @include('public.components.search.index')


                    <!-- suggestion articles -->
                    <div class="mt-8 lg:mt-0 lg:px-6">
                        <h2 class="mt-4 mb-4 text-2xl font-semibold text-slate-900">
                            আরও রিলেটেড গল্প পড়ুন
                        </h2>
                        @foreach ($post->related() as $post)
                            @include('public.post.partials.related', $post)
                        @endforeach
                    </div>
                </aside>
            </div>

        </div>
    </section>
@endsection
