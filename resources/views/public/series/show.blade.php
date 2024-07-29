@extends('public.app')

@section('title', $series->name)
@section('canonical', route('series', ['series' => $series->slug]))

@section('content')

    <!-- breadcrums -->
    @include('public.post.utility.breadcrumbs', [
        'breadcrumbs' => [
            // [
            //     'title' => 'series',
            //     'url' => route('series'),
            // ],
            [
                'title' => $series->name,
                'url' => route('series', ['series' => $series->slug]),
            ],
        ],
    ])

    <section class="bg-gray-100 py-5 md:py-10">
        <div class="margin-responsive bg-white">

            <div class="relative px-5 md:px-10 lg:px-14">
                <h1
                    class="z-10 m-auto py-5 text-center font-trebuchet text-[40px] font-extrabold capitalize text-slate-900 md:py-14">
                    {{ $series->name }}
                    <div class="mt-2 flex justify-center">
                        <hr class="w-3 border-b-4 border-theme-color md:w-1/12">
                    </div>
                </h1>

                <div class="mb-5">
                    <div class="relative text-left">
                        <p class="mb-3 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                            {{ $series->description }}
                        </p>
                    </div>
                </div>


                <div class="mt-8 grid grid-cols-1 gap-8 pb-8 lg:grid-cols-3">
                    @foreach ($series->post as $post)
                        @include('public.post.partials.card', $post)
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-10 mb-4 pb-8">
                    {{ $series->post->links() }}
                </div>
            </div>

        </div>
    </section>
@endsection
