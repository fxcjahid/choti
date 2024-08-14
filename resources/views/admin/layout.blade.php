@extends('admin.app')

@section('content')
    @include('admin.components.header')

    <!-- main content -->
    <main class="inline-flex w-full" areia-label="content">
        @include('admin.components.sidebar')
        <div class="w-full p-8">
            @include('admin.components.errors')
            <!-- posts content -->
            <section aria-label="post">
                <div class="mt-3">

                    <!-- filter option -->

                    <div class="w-full">
                        <div class="inline-flex w-full justify-between">
                            @include('admin.components.post.switch-post-type')
                            @include('admin.components.post.switch-post-filter')
                        </div>
                    </div>


                    <!-- card list -->

                    <section class="mt-1">
                        <dashboard-index v-slot="vm">
                            @foreach ($posts as $post)
                                <article
                                    class="post-containter mb-9 justify-between rounded-xl border bg-white shadow-sm transition hover:shadow-md hover:shadow-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:shadow-slate-700/[.7] sm:flex">

                                    <div
                                        class="my-5 mx-4 md:mx-8 h-60 w-auto flex-shrink-0 rounded-t-xl md:h-36 md:w-36 lg:h-40 lg:w-40">
                                        <a href="{{ route('admin.create.get', $post->id) }}">
                                            @php
                                                $thumbnail = !empty(isset($post->thumbnail[0]->path))
                                                    ? $post->thumbnail[0]->path
                                                    : asset('/assets/public/img/thumbnail-placeholder.png');
                                            @endphp
                                            <img class="h-full w-full rounded-xl object-cover" src="{{ $thumbnail }}"
                                                alt="Thumbnail">
                                        </a>
                                    </div>
                                    <!-- content -->
                                    <div class="flex w-full flex-wrap">
                                        <div class="flex h-full flex-col md:py-6 px-4 md:px-0">
                                            <a href="{{ route('admin.create.get', $post->id) }}"
                                                class="text-lg font-bold text-gray-800 hover:text-blue-800 dark:text-white">
                                                {{ $post->title ?? 'Untitled' }}
                                            </a>
                                            <div class="mt-5 flex items-center sm:mt-auto">
                                                <div class="text-sm capitalize text-gray-500 dark:text-gray-500">
                                                    {{ $post->status }}
                                                </div>

                                                <div class="hs-tooltip -mt-1 inline-block">
                                                    <div class="hs-tooltip-toggle inline-flex">
                                                        <div
                                                            class="before-point relative ml-4 flex items-center pl-[20px] text-sm text-gray-500 dark:text-gray-500">
                                                            {{ $post->created_at->format('d M, Y') }}
                                                        </div>
                                                        <span
                                                            class="hs-tooltip-content invisible absolute z-10 inline-block rounded-md bg-gray-900 py-1 px-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:bg-slate-700"
                                                            role="tooltip">
                                                            {{ $post->created_at->format('h:i A,  d-M-Y') }}
                                                            |
                                                            {{ $post->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="mt-1">
                                                <div class="hs-tooltip inline-block">
                                                    <div class="hs-tooltip-toggle inline-flex">
                                                        <div class="text-sm text-gray-500 dark:text-gray-500">
                                                            Last Update:
                                                            {{ $post->updated_at->diffForHumans() }}
                                                        </div>
                                                        <span
                                                            class="hs-tooltip-content invisible absolute z-10 inline-block rounded-md bg-gray-900 py-1 px-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:bg-slate-700"
                                                            role="tooltip">
                                                            {{ $post->created_at->format('h:i A,  d-M-Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 md:mt-auto">
                                                <div class="flex justify-start gap-2 flex-wrap">
                                                    @foreach ($post->tag as $tag)
                                                        <span
                                                            class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 py-1.5 px-3 text-xs font-medium text-gray-500">
                                                            {{ $tag->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tools md:flex flex-wrap">
                                        <div
                                            class="flex space-y-6 h-full min-w-[150px] flex-wrap py-2 md:py-6 px-2 transition-all">

                                            <!-- tools -->
                                            <div class="post-tools-hover m-auto w-full transition">
                                                <div
                                                    class="flex justify-center gap-5 rounded-full -md:mx-3 -md:mt-2 p-2 shadow">


                                                    <div
                                                        class="hs-tooltip inline-block h-8 w-8 cursor-pointer p-1 text-gray-500">
                                                        <a href="{{ $post->url() }}" target="_blank"
                                                            class="hs-tooltip-toggle">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z" />
                                                            </svg>
                                                            <span
                                                                class="hs-tooltip-content invisible absolute z-10 inline-block rounded-md bg-gray-900 py-1 px-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:bg-slate-700"
                                                                role="tooltip">
                                                                View Post
                                                            </span>
                                                        </a>
                                                    </div>

                                                    <div v-on:click="vm.makeDraft('{{ $post->id }}')"
                                                        class="hs-tooltip inline-block h-[30px] w-[30px] cursor-pointer p-1 text-gray-500">
                                                        <div class="hs-tooltip-toggle">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M504 255.531c.253 136.64-111.18 248.372-247.82 248.468-59.015.042-113.223-20.53-155.822-54.911-11.077-8.94-11.905-25.541-1.839-35.607l11.267-11.267c8.609-8.609 22.353-9.551 31.891-1.984C173.062 425.135 212.781 440 256 440c101.705 0 184-82.311 184-184 0-101.705-82.311-184-184-184-48.814 0-93.149 18.969-126.068 49.932l50.754 50.754c10.08 10.08 2.941 27.314-11.313 27.314H24c-8.837 0-16-7.163-16-16V38.627c0-14.254 17.234-21.393 27.314-11.314l49.372 49.372C129.209 34.136 189.552 8 256 8c136.81 0 247.747 110.78 248 247.531zm-180.912 78.784l9.823-12.63c8.138-10.463 6.253-25.542-4.21-33.679L288 256.349V152c0-13.255-10.745-24-24-24h-16c-13.255 0-24 10.745-24 24v135.651l65.409 50.874c10.463 8.137 25.541 6.253 33.679-4.21z" />
                                                            </svg>
                                                            <span
                                                                class="hs-tooltip-content invisible absolute z-10 inline-block rounded-md bg-gray-900 py-1 px-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:bg-slate-700"
                                                                role="tooltip">
                                                                Make as Draft
                                                            </span>
                                                        </div>
                                                    </div>

                                                    @if ($post->status == 'trash')
                                                        <div v-on:click="vm.delete('{{ $post->id }}')"
                                                            class="hs-tooltip inline-block h-7 w-7 cursor-pointer p-1 text-gray-500">
                                                            <div class="hs-tooltip-toggle">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 448 512" fill="currentColor">
                                                                    <path
                                                                        d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z" />
                                                                </svg>
                                                                <span
                                                                    class="hs-tooltip-content invisible absolute z-10 inline-block rounded-md bg-gray-900 py-1 px-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:bg-slate-700"
                                                                    role="tooltip">
                                                                    Delete Permanently
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div v-on:click="vm.moveTrash('{{ $post->id }}')"
                                                            class="hs-tooltip inline-block h-7 w-7 cursor-pointer p-1 text-gray-500">
                                                            <div class="hs-tooltip-toggle">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 448 512" fill="currentColor">
                                                                    <path
                                                                        d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z" />
                                                                </svg>
                                                                <span
                                                                    class="hs-tooltip-content invisible absolute z-10 inline-block rounded-md bg-gray-900 py-1 px-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:bg-slate-700"
                                                                    role="tooltip">
                                                                    Move to trash
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endif


                                                    <div
                                                        class="hs-tooltip inline-block h-7 w-7 cursor-pointer p-1 text-gray-500">
                                                        <div class="hs-tooltip-toggle">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                                fill="currentcolor">
                                                                <path
                                                                    d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
                                                            </svg>
                                                            <span
                                                                class="hs-tooltip-content invisible absolute z-10 inline-block rounded-md bg-gray-900 py-1 px-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:bg-slate-700"
                                                                role="tooltip">
                                                                Author
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- author -->
                                            <div class="post-tools-author m-auto w-full">
                                                <div class="flex items-center justify-end gap-3">
                                                    <span class="text-sm text-gray-800">
                                                        {{ $post->author }}
                                                    </span>
                                                    <div class="mr-3 inline-flex h-6 w-6">
                                                        <img src="https://avatars.dicebear.com/api/avataaars/example.svg?options[top][]=shortHair&amp;options[accessoriesChance]=93"
                                                            alt="John Doe"
                                                            class="block h-auto w-full max-w-full rounded-full bg-gray-100 dark:bg-slate-800">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- statics -->
                                            <div class="mt-auto mr-4 flex w-full flex-wrap justify-end gap-4">
                                                <div class="flex">
                                                    <div class="text-gray-700" aria-lavel="comment">
                                                        0 <i class="fa fa-comment-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="flex">
                                                    <div class="text-gray-700" aria-lavel="comment">
                                                        {{ views($post)->remember(15)->count() }}
                                                        <i class="fa fa-chart-line"></i>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </article>
                            @endforeach


                        </dashboard-index>
                        <div class="d-flex justify-content-center mt-10 mb-4">
                            {{ $posts->links('admin.components.pagination') }}
                        </div>
                    </section>

                </div>
            </section>
        </div>
    </main>
@endsection
