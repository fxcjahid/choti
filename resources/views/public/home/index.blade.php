@extends('public.app')

@section('title', 'Blanee : votre allié contre les nuisibles')
@section('canonical', route('home'))
@section('content')
    <!-- page content start -->
    <main class="">
        <div class="2xl:m-auto 2xl:max-w-screen-2xl">

            <!-- block -->
            <section class="bg-gray-100 py-5 md:py-10">
                <div class="bg-white flex lg:flex-row margin-responsive">
                    <div class="w-full lg:w-9/12">
                        <div class="p-0">
                            @foreach ($posts as $index => $post)
                                @include('public.post.partials.card')
                            @endforeach
                        </div>
                    </div>

                    <div class="w-full lg:w-3/12 lg:border-l-4 lg:border-gray100 p-2">
                        <img class="mx-auto rounded max-h-[488px]" src="https://placehold.co/350x670">
                    </div>
                </div>
            </section>
        </div>
    </main>

@endsection
