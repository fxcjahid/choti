@extends('public.app')

@section('title', 'Qui sommes-nous - Blanee.com')
@section('canonical',
    route('service.coverage', [
    'service' => request()->route('service'),
    ]))

@section('content')
    <main class="">
        {{-- Intro block 01  --}}
        <section class="bg-gray-100 pt-5 md:pt-10">
            <div class="margin-responsive bg-white">
                <div class="relative px-5 md:px-10 lg:px-14">
                    <h1
                        class="z-10 m-auto py-5 text-center font-trebuchet text-[40px] font-extrabold capitalize text-slate-900 md:py-14">
                        {!! $load['coverage']['title'] !!}
                        <div class="mt-2 flex justify-center">
                            <hr class="w-3 border-b-4 border-theme-color md:w-1/12">
                        </div>
                    </h1>
                </div>
            </div>
        </section>

        {{-- city list --}}

        <section class="bg-gray-100 pb-5 md:pb-10">
            <div class="margin-responsive bg-white">
                @foreach ($region as $region => $city)
                    <div class="px-8 py-5 md:px-16">
                        <p
                           class="mb-3 font-trebuchet text-2xl font-extrabold capitalize text-slate-900">
                            {{ $region }}
                        </p>
                        <div class="">
                            <ul class="ml-5 !list-disc columns-4 gap-x-10 text-lg">
                                @foreach ($city as $item)
                                    <li class="py-0.5">
                                        <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => $item->city_slug]) }}"
                                           class="hover:text-blue-800">
                                            {{ $item->city_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </main>
@endsection
