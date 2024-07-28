@extends('public.app')

@section('title', 'Guides Anti-nuisibles - Blanee.com')
@section('canonical', route('guides-nuisibles'))

@section('content')
    <main class="">

        <!-- breadcrums -->
        @include('public.post.utility.breadcrumbs', [
            'breadcrumbs' => [
                [
                    'title' => 'Guides Anti-nuisibles',
                    'url' => route('guides-nuisibles'),
                ],
            ],
        ])


        <!-- Intro block 01 -->
        <section class="bg-gray-100 pt-5 md:pt-10">
            <div class="margin-responsive bg-white">
                <div class="relative flex flex-wrap px-5 pt-3 md:px-10 md:pb-10">
                    <div
                         class="z-1 m-auto py-5 text-center font-trebuchet text-[40px] font-extrabold text-slate-900 md:py-12">
                        À quel type de nuisible faites-vous face ?
                        <div class="mt-2 flex justify-center">
                            <hr class="w-3 border-b-4 border-theme-color md:w-1/12">
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="relative text-left">
                            <p
                               class="font-nato text-base font-normal text-slate-900 sm:mx-auto">
                                Vous venez de trouver des insectes dans votre lit ?
                                Peut-être que quelque chose a mangé la nourriture dans
                                votre garde-manger ? Ou peut-être avez-vous remarqué
                                qu'une colonie de fourmis de feu s'est réfugiée dans votre
                                jardin. Eh bien, vous avez de la chance, car Blanee est là
                                pour vous aider à vous débarrasser de vos problèmes
                                d'insectes et de rongeurs.
                            </p>
                        </div>
                    </div>

                    <div class="relative text-left">
                        <p
                           class="mb-3 font-nato text-base font-normal text-slate-900 sm:mx-auto">
                            Qu'il s'agisse de punaises de lit, de cafards, de souris,
                            de rats et plus encore, Blanee peut vous guider tout au
                            long de votre parcours d'élimination des parasites.
                            Sélectionnez simplement le type d'insecte auquel vous
                            faites face ci-dessous pour commencer.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gray-100 pb-5 md:pb-10">

            @foreach ($data as $posts)
                @if ($posts->post_count >= 1)
                    <div class="margin-responsive bg-white">
                        <div class="border-t border-slate-200 px-5 md:px-10 lg:px-14">
                            <div class="py-5">
                                <div
                                     class="mt-4 font-trebuchet text-3xl font-extrabold capitalize text-slate-900">
                                    {{ $posts->name }}
                                </div>
                                @if ($posts->description)
                                    <div class="mt-2 mb-5">
                                        <div class="relative text-left">
                                            <p
                                               class="mb-3 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                                                {{ $posts->description }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                <div class="mt-3 grid grid-cols-1 gap-8 pb-8 lg:grid-cols-3">
                                    @foreach ($posts->post as $post)
                                        @include('public.post.partials.card')
                                    @endforeach
                                </div>
                                @if ($posts->post_count > 3)
                                    <a href="{{ route('category', ['category' => $posts->slug]) }}"
                                       class="mt-1 mb-8 inline-flex items-center rounded-lg bg-theme-color px-3 py-1.5 text-base capitalize text-white hover:bg-theme-light">
                                        Autres articles sur {{ $posts->name }} <svg
                                             aria-hidden="true"
                                             class="ml-2 -mr-1 h-5 w-5"
                                             fill="currentColor"
                                             viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                  d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                @endif
            @endforeach

        </section>

    </main>
@endsection
