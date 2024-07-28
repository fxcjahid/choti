@extends('public.app')

@section('title', 'Tarifs lutte contre les nuisibles en France')

@section('content')
    <main class="">

        <!-- Intro block 01 -->

        @include('public.page.partials.heading', [
            'title' => 'Tarifs de la lutte contre les nuisibles',
            'paragraph' => 'Découvrez les coûts de l\'élimination des nuisibles',
        ])

        @include('public.page.partials.breadcrumbs', [
            'breadcrumbs' => [
                [
                    'title' => 'Prix',
                    'url' => '',
                ],
            ],
        ])

        <section class="bg-white pb-5 md:pb-10">

            @foreach ($data as $posts)
                @if ($posts->post_count >= 1)
                    <div class="margin-responsive mt-5 bg-white">
                        <div class="py-5">
                            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                                @foreach ($posts->post as $post)
                                    @include('public.post.partials.card')
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </section>

    </main>
@endsection
