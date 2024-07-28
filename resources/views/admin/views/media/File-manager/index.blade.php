@extends('admin.app')
@section('title', 'Media')
@section('content')

    <!-- main content -->
    <main class="inline-flex w-full"
          areia-label="content">

        <div role="file-manager"
             class="w-full py-4 px-5">
            @include('admin.components.flash-message')
            @include('admin.views.media.File-manager.table')
        </div>
    </main>
@endsection
