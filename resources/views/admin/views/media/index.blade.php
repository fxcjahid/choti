@extends('admin.app')
@section('title', 'Media')
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

            @include('admin.components.flash-message')

            @include('admin.views.media.partials.uploader')
        </div>
    </main>
@endsection
