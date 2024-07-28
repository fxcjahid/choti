@extends('admin.app')
@section('title', 'Catagories')
@section('content')
    @include('admin.components.header')
    <!-- main content -->
    <main class="inline-flex w-full"
          areia-label="content">
        @include('admin.components.sidebar')
        <div role="catogories"
             class="w-full py-5 px-5">
            <div
                 class="mb-4 text-2xl font-semibold capitalize text-gray-600 dark:text-gray-200">
                Media
            </div>

            <div class="flex w-full items-center justify-center">
                <label for="dropzone-file"
                       class="dark:hover:bg-bray-800 flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg aria-hidden="true"
                             class="mb-3 h-10 w-10 text-gray-400"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                  class="font-semibold">Click to upload</span> or drag and
                            drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or
                            GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="dropzone-file"
                           type="file"
                           class="hidden">
                </label>
            </div>
        </div>
    </main>
@endsection
