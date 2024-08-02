@extends('public.account.index')
@section('subcontent')
    <div class="profile-edits">
        <div class="mb-5 border-b border-gray-100">
            <h1 class="mb-3 text-xl md:text-2xl text-slate-900">
                My all posts
            </h1>
        </div>
        <div class="my-10">
            @include('public.account.utility.post-loop')
        </div>
    </div>
@endsection
