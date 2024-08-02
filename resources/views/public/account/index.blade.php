@extends('public.app')

@section('title', trans('account.title'))
@section('canonical', route('public.account.index'))
@section('content')
    <main class="settings bg-white dark:bg-gray-900">
        <div class="m-auto">
            <div class="bg-white margin-responsive md:pb-16">
                <div class="my-5 md:mt-10 border-b border-gray-100">
                    <h1 class="mb-6 text-2xl md:text-3xl text-slate-900">
                        Settings
                    </h1>
                </div>
                <div class="lg:flex lg:flex-row">
                    <div class="w-full lg:w-3/12 border-r border-gray-100">
                        @include('public.account.utility.sidebar')
                    </div>
                    <div class="w-full lg:w-9/12">
                        <div class="setting-content">
                            @yield('subcontent')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
