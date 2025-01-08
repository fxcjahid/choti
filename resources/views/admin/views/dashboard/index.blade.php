@extends('admin.app')

@section('content')
    @include('admin.components.header')

    <main class="inline-flex w-full" areia-label="content">
        @include('admin.components.sidebar')
        <div class="w-full p-8">
            @include('admin.components.errors')

            @include('admin.views.dashboard.metrics')
            @include('admin.views.dashboard.chart')

            <div class="flex items-start gap-5">
                @include('admin.views.dashboard.channel')
                @include('admin.views.dashboard.country')
                {{-- @include('admin.views.dashboard.searches') --}}
            </div>

            <div class="flex items-start gap-5 my-10">
                @include('admin.views.dashboard.tops_post')
                @include('admin.views.dashboard.searches')
            </div>
        </div>
    </main>
@endsection
