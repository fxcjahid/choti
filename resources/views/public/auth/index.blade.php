@extends('public.app')

@section('title', trans('auth.title'))
@section('canonical', route('public.auth.index'))
@section('content')
    <main class="desktop-auth">
        <div class="2xl:m-auto 2xl:max-w-screen-2xl">
            <div class="mx-auto max-w-screen-md px-4 py-5 lg:pb-16">
                @include('public.components.auth.mobile')
            </div>
        </div>
    </main>
@endsection