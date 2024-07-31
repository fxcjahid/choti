@extends('admin.app')

@section('title', 'Create New Post')

@section('content')
    <header class="sticky top-0 z-40 bg-white dark:bg-gray-800">
        <div class="m-auto min-h-[65px] border-b border-solid border-gray-200">
            <div class="inline-flex h-full min-h-[inherit] w-full items-center justify-between">
                <!-- Left Side Bar -->
                <div class="" areia-lable="navigation">
                    <div class="flex h-full items-center gap-5 px-6">
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex select-none items-center gap-3 rounded-full border-none py-2 px-3 outline-none hover:bg-slate-100">
                            <i class="fa fa-arrow-left"></i>
                            <div class="flex">
                                <span class="font-medium">Back</span>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- Right sidebar -->
                <div class="inline-flex items-center gap-3">

                    <!-- Switch Mode -->
                    <div
                        class="relative block cursor-pointer items-center py-2 px-3 text-black hover:text-zinc-500 dark:text-white dark:hover:text-slate-400 lg:flex lg:w-16 lg:justify-center">
                        <div class="flex items-center">
                            <span class="inline-flex h-7 w-7 items-center justify-center transition-colors">
                                <svg viewBox="0 0 24 24" width="25" height="25"
                                    class="inline-block cursor-pointer text-slate-500 transition-all hover:text-slate-900">
                                    <path fill="currentColor"
                                        d="M7.5,2C5.71,3.15 4.5,5.18 4.5,7.5C4.5,9.82 5.71,11.85 7.53,13C4.46,13 2,10.54 2,7.5A5.5,5.5 0 0,1 7.5,2M19.07,3.5L20.5,4.93L4.93,20.5L3.5,19.07L19.07,3.5M12.89,5.93L11.41,5L9.97,6L10.39,4.3L9,3.24L10.75,3.12L11.33,1.47L12,3.1L13.73,3.13L12.38,4.26L12.89,5.93M9.59,9.54L8.43,8.81L7.31,9.59L7.65,8.27L6.56,7.44L7.92,7.35L8.37,6.06L8.88,7.33L10.24,7.36L9.19,8.23L9.59,9.54M19,13.5A5.5,5.5 0 0,1 13.5,19C12.28,19 11.15,18.6 10.24,17.93L17.93,10.24C18.6,11.15 19,12.28 19,13.5M14.6,20.08L17.37,18.93L17.13,22.28L14.6,20.08M18.93,17.38L20.08,14.61L22.28,17.15L18.93,17.38M20.08,12.42L18.94,9.64L22.28,9.88L20.08,12.42M9.63,18.93L12.4,20.08L9.87,22.27L9.63,18.93Z">
                                    </path>
                                </svg>
                            </span>
                            <span class="sr-only">Light/Dark</span>
                        </div>
                    </div>


                    <!-- Profile -->
                    <div
                        class="mr-4 flex items-center bg-gray-100 p-3 dark:bg-slate-800 lg:bg-transparent lg:p-0 lg:dark:bg-transparent">
                        <div class="inline-flex h-6 w-6">
                            <img src="https://avatars.dicebear.com/api/avataaars/example.svg?options[top][]=shortHair&amp;options[accessoriesChance]=93"
                                alt="John Doe"
                                class="block h-auto w-full max-w-full rounded-full bg-gray-100 dark:bg-slate-800" />
                        </div>
                        <div class="px-2 font-medium capitalize transition-colors">
                            {{ auth()->user()->name() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- main content -->
    <main class="inline-flex w-full" areia-label="content">
        <create-post v-slot="vm" :posts="{{ $post }}">
            <div class="w-full p-8">
                <!-- posts content -->
                <section aria-label="post">

                    <form @submit.prevent>
                        <div class="mt-3">
                            <label for="title"
                                class="relative block overflow-hidden border-b border-gray-200 pt-3 focus-within:border-b-2 focus-within:border-theme-color">
                                <input type="text" id="title" name="title" placeholder="Type your title"
                                    v-model="vm.form.title"
                                    class="peer h-8 w-full border-none bg-transparent p-0 placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 sm:text-2xl" />

                                <span
                                    class="absolute left-0 top-3 -translate-y-1/2 text-[0px] font-medium text-gray-800 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-2xl peer-focus:top-2 peer-focus:text-sm">
                                    Post Title
                                </span>
                            </label>
                        </div>

                        <div class="-mx-4 mt-5 flex flex-wrap">
                            <div class="w-full px-4">
                                <p class="my-2 text-xl font-medium">Content</p>
                                <Cretate-Post-Editor class="rounded-md border" setdata="{{ $post->content }}">
                                </Cretate-Post-Editor>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
            <!-- Right sidebar -->
            <div
                class="scrollbar sticky top-[67px] flex h-[calc(100vh-68px)] w-96 flex-col border-l bg-white px-4 py-1 hover:overflow-y-auto dark:border-gray-700 dark:bg-gray-900">

                <div class="mt-6 flex flex-1 flex-col">
                    <div class="mx-auto flex justify-around gap-4">
                        <div class="inline-flex rounded-md shadow-sm">
                            <button type="button" v-on:click="vm.viewPost"
                                class="-ml-px inline-flex items-center justify-center gap-2 border bg-white py-3 px-4 align-middle text-sm font-medium text-gray-700 transition-all first:ml-0 first:rounded-l-lg last:rounded-r-lg hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-slate-800">
                                Preview
                            </button>
                        </div>

                        <div class="relative inline-flex rounded-md shadow-sm" x-data="{ open: false }">
                            <button type="button" v-on:click="vm.publish"
                                :class="vm.isloading ? 'btn-loading disabled bg-green-800' :
                                    ''"
                                :disabled="vm.isloading"
                                class="round-r-0 -ml-px inline-flex items-center justify-center gap-2 border bg-white py-3 px-4 align-middle text-sm font-medium text-gray-700 transition-all first:ml-0 first:rounded-l-lg last:rounded-r-lg hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-slate-800">
                                Publish
                            </button>
                            <button type="button" x-on:click="open = ! open"
                                class="focus:rounded-br-no ne -ml-px inline-flex items-center justify-center gap-2 rounded-r-lg border bg-white py-3 px-2 align-middle text-sm font-medium text-gray-700 transition-all first:ml-0 first:rounded-l-lg hover:bg-gray-50 focus:first:hidden dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-slate-800">
                                <svg class="h-3.5 w-3.5 text-gray-600 hs-dropdown-open:rotate-180" width="16"
                                    height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z" />
                                </svg>
                            </button>
                            <div x-show="open"
                                class="drop-show absolute top-[40px] left-0 z-10 w-full rounded-tl-none rounded-tr-none border last:rounded-b-lg">
                                <div class="flex flex-wrap">
                                    <button type="button" v-on:click="vm.save" class="btn">
                                        Save
                                    </button>
                                    <button type="button" v-on:click="vm.draft" class="btn">
                                        Draft
                                    </button>
                                    <button type="button" class="btn">
                                        Schedule
                                    </button>
                                    <button type="button" v-on:click="vm.trash" class="btn">
                                        Trash
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav aria-label="menu" class="post-settings mt-7">

                        <div class="my-2" x-data="{ open: false }">
                            <button type="button" x-on:click="open = ! open"
                                class="flex w-full items-center justify-between gap-3">
                                <div class="mr-4 font-medium">Status & Visibility</div>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="mt-2" x-show="open">
                                <div role="option" class="px-2 py-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <div role="item" class="font-light text-gray-500">
                                            Visibility
                                        </div>
                                        <div role="item" class="font-light text-blue-500">
                                            <div class="hs-dropdown relative inline-flex"
                                                data-hs-dropdown-auto-close="inside">
                                                <button id="hs-dropdown-item-checkbox" type="button"
                                                    class="hs-dropdown-toggle inline-flex items-center justify-center gap-2 outline-none transition-all">
                                                    <div class="mr-1 font-light text-blue-500">
                                                        Public
                                                    </div>
                                                </button>

                                                <div class="hs-dropdown-menu duration z-10 mt-2 hidden min-w-[13rem] max-w-[250px] rounded-lg border bg-white p-2 opacity-0 shadow-md transition-[opacity,margin] hs-dropdown-open:opacity-100 dark:border dark:border-gray-700 dark:bg-gray-800"
                                                    aria-labelledby="hs-dropdown-item-checkbox">
                                                    <p class="ml-3 py-2 text-sm font-medium text-slate-900">
                                                        Post Visibility
                                                    </p>
                                                    <div
                                                        class="relative flex items-start rounded-md py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <div class="mt-1 flex h-5 items-center">
                                                            <input id="hs-dropdown-item-radio-delete"
                                                                name="hs-dropdown-item-radio" type="radio"
                                                                class="rounded-full border-gray-200 text-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:checked:border-blue-500 dark:checked:bg-blue-500"
                                                                aria-describedby="hs-dropdown-item-radio-delete-description"
                                                                checked>
                                                        </div>
                                                        <label for="hs-dropdown-item-radio-delete" class="ml-3.5">
                                                            <span
                                                                class="block text-sm font-semibold text-gray-800 dark:text-gray-300">
                                                                Public
                                                            </span>
                                                            <span id="hs-dropdown-item-radio-delete-description"
                                                                class="block text-sm text-gray-600 dark:text-gray-500">
                                                                Visible to everyone.
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div
                                                        class="relative flex items-start rounded-md py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <div class="mt-1 flex h-5 items-center">
                                                            <input id="hs-dropdown-item-radio-archive"
                                                                name="hs-dropdown-item-radio" type="radio"
                                                                class="rounded-full border-gray-200 text-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:checked:border-blue-500 dark:checked:bg-blue-500"
                                                                aria-describedby="hs-dropdown-item-radio-archive-description">
                                                        </div>
                                                        <label for="hs-dropdown-item-radio-archive" class="ml-3.5">
                                                            <span
                                                                class="block text-sm font-semibold text-gray-800 dark:text-gray-300">
                                                                Private
                                                            </span>
                                                            <span id="hs-dropdown-item-radio-archive-description"
                                                                class="block text-sm text-gray-600 dark:text-gray-500">
                                                                Only visible to site admins
                                                                and editors.
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div
                                                        class="relative flex items-start rounded-md py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <div class="mt-1 flex h-5 items-center">
                                                            <input id="hs-dropdown-item-radio-password"
                                                                name="hs-dropdown-item-radio" type="radio"
                                                                class="rounded-full border-gray-200 text-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:checked:border-blue-500 dark:checked:bg-blue-500"
                                                                aria-describedby="hs-dropdown-item-radio-archive-description">
                                                        </div>
                                                        <label for="hs-dropdown-item-radio-password" class="ml-3.5">
                                                            <span
                                                                class="block text-sm font-semibold text-gray-800 dark:text-gray-300">
                                                                Password Protected
                                                            </span>
                                                            <span id="hs-dropdown-item-radio-archive-description"
                                                                class="block text-sm text-gray-600 dark:text-gray-500">
                                                                Protected with a password you
                                                                choose. Only those with the
                                                                password can view this post.
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="option" class="px-2 py-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <div role="item" class="font-light text-gray-500">
                                            Post at
                                        </div>
                                        <div role="item" class="font-light text-blue-500">
                                            Immediately
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-2" x-data="{ open: false }">
                            <button type="button" x-on:click="open = ! open"
                                class="flex w-full items-center justify-between gap-3">
                                <div class="mr-4 font-medium">Permalink</div>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="mt-2" x-show="open">
                                <div role="option" class="px-2 py-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <div role="item" class="overflow-anywhere font-light text-slate-900">
                                            {{ url('/') }}/<span v-text="vm.getFirstCategory"
                                                class="overflow-anywhere"></span>/<span v-text="vm.getPostTitle"
                                                class="overflow-anywhere"></span>
                                        </div>
                                    </div>
                                </div>
                                <div role="option" class="px-2 py-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <div role="item" class="font-light text-gray-500">
                                            <div class="flex">
                                                <input type="radio" name="hs-default-radio"
                                                    class="mt-0.5 h-4 w-4 shrink-0 rounded-full border-gray-200 text-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:checked:border-blue-500 dark:checked:bg-blue-500"
                                                    id="hs-default-radio" v-model="vm.form.permalink.custom"
                                                    :value="false" checked>
                                                <label for="hs-default-radio"
                                                    class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-400">
                                                    Automatic Permalink
                                                </label>
                                            </div>

                                            <div class="mt-2">
                                                <input type="radio" name="hs-default-radio"
                                                    class="mt-0.5 h-4 w-4 shrink-0 rounded-full border-gray-200 text-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:checked:border-blue-500 dark:checked:bg-blue-500"
                                                    id="hs-custom-radio" v-model="vm.form.permalink.custom"
                                                    :value="true">
                                                <label for="hs-custom-radio"
                                                    class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-400">
                                                    Custom Permalink
                                                </label>
                                                <input v-if="vm.form.permalink.custom" v-model="vm.form.permalink.link"
                                                    type="text" name="hs-default-radio"
                                                    class="mt-3 w-full rounded border border-slate-300 p-1 text-slate-900 outline-0 ring-0 ring-offset-0"
                                                    autocomplete="off" spellcheck="false">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-2" x-data="{ open: false }">
                            <button type="button" x-on:click="open = ! open"
                                class="flex w-full items-center justify-between gap-3">
                                <div class="mr-4 font-medium">Categories</div>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="mt-2" x-show="open">
                                <div role="option" class="py-2">
                                    <select id="select-categories" name="state[]" multiple v-model="vm.form.category"
                                        placeholder="Select a category..." autocomplete="off">
                                        @foreach ($category as $row)
                                            <option value="{{ $row->id }}" data-slug="{{ $row->slug }}">
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="my-2" x-data="{ open: false }">
                            <button type="button" x-on:click="open = ! open"
                                class="flex w-full items-center justify-between gap-3">
                                <div class="mr-4 font-medium">Series</div>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="mt-2" x-show="open">
                                <div role="option" class="py-2">
                                    <select id="select-series" name="state[]" multiple v-model="vm.form.series"
                                        placeholder="Select a series..." autocomplete="off">
                                        @foreach ($series as $row)
                                            <option value="{{ $row->id }}" data-slug="{{ $row->slug }}">
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="my-2" x-data="{ open: false }">
                            <button type="button" x-on:click="open = ! open"
                                class="flex w-full items-center justify-between gap-3">
                                <div class="mr-4 font-medium">Tags</div>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="mt-2" x-show="open">
                                <div role="option" class="py-2">
                                    <select id="select-tags" name="tags[]" v-model="vm.form.tag" multiple
                                        placeholder="Select a category..." autocomplete="off">
                                        @foreach ($tags as $row)
                                            <option value="{{ $row->id }}">
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="my-2" x-data="{ open: false }">
                            <button type="button" x-on:click="open = ! open"
                                class="flex w-full items-center justify-between gap-3">
                                <div class="mr-4 font-medium">Featured Image</div>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="mt-2" x-show="open">
                                <div role="option" class="px-2 py-2">

                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex w-full items-center justify-center" tabindex="0">

                                            <div v-on:click="vm.open" role="select image" v-if="!vm.getPostThumbnail"
                                                class="flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-800">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <div>
                                                        <svg aria-hidden="true"
                                                            class="mx-auto mb-3 h-10 w-10 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                            </path>
                                                        </svg>
                                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                            <span class="font-semibold">
                                                                Click to upload
                                                            </span>
                                                            or drag and drop
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            SVG, PNG, JPG or GIF (MAX.
                                                            800x400px)
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="placholder-image" v-if="vm.getPostThumbnail">
                                                <div
                                                    class="h-64 rounded-lg border-2 border-dashed border-gray-300 bg-gray-50">
                                                    <img class="h-full w-auto rounded-lg" :src="vm.getPostThumbnail.path">
                                                </div>
                                                <div class="mt-5 flex justify-center gap-3">
                                                    <button @click="vm.open"
                                                        class="flex transform items-center rounded-lg bg-blue-600 px-1 py-1 text-sm font-normal capitalize tracking-wide text-white transition-colors duration-300 hover:bg-blue-500 focus:outline-none">
                                                        <svg class="mx-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                                                clip-rule="evenodd" />
                                                        </svg>

                                                        <span class="mx-1">Change</span>
                                                    </button>
                                                    <button @click="vm.remove"
                                                        class="flex transform items-center rounded-lg bg-red-600 px-1 py-2 text-sm font-normal capitalize tracking-wide text-white transition-colors duration-300 hover:bg-red-500 focus:outline-none">
                                                        <svg aria-hidden="true" class="mx-1 h-5 w-5" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="mx-1">Remove</span>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </nav>
                </div>
            </div>


            <file-manager v-if="vm.openModal" @open="vm.open" @close="vm.close" @select="vm.select"></file-manager>

        </create-post>
    </main>
@endsection
