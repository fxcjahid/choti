@extends('public.app')

@section('title', $title)
@section('canonical',
    route('service.page', [
    'service' => request()->route('service'),
    'city' => request()->route('city'),
    ]))


@section('content')
    <main class="landing-page">
        <section class="bg-white dark:bg-gray-900">
            <div class="mx-auto max-w-screen-2xl">
                <!-- Hero Section -->
                <section class="hero bg lg:max-h-[48rem] lg:bg-hero -md:bg-slate-100">
                    <div
                         class="margin-responsive my-auto flex h-full flex-col-reverse space-y-6 sm:flex-col lg:flex-row lg:items-center">
                        <div class="w-full lg:w-1/2">
                            <div class="pt-8 md:pt-0 lg:pl-5">
                                <h1 aria-label="title"
                                    class="font-trebuchet text-2xl font-bold !leading-[initial] tracking-wide text-slate-900 dark:text-white lg:mt-6 lg:text-4xl">
                                    {{ $hero->heading }}
                                </h1>
                                <p class="mt-7 text-xl font-medium text-slate-800 md:text-2xl">
                                    {{ $hero->paragraph }}
                                </p>
                                <ul class="mt-3 space-y-2 text-base leading-tight md:text-lg">
                                    @foreach ($hero->orderList as $item)
                                        <li class="-mx-2 flex items-center text-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="mx-2 h-5 min-h-[20px] w-5 min-w-[20px] text-green-500"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="mx-2">
                                                {{ $item }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-8 lg:pl-5">
                                <p class="text-2xl font-medium text-slate-800">
                                    {{ $price }}
                                </p>
                            </div>
                            <div
                                 class="mt-9 flex flex-wrap gap-7 sm:gap-10 md:mt-5 md:ml-5 md:flex-nowrap">
                                <div
                                     class="animate-wiggle cursor-pointer rounded-md border-2 border-red-600 bg-red-600 px-4 py-2 transition-all hover:animate-none hover:bg-theme-light hover:shadow-md">
                                    <div class="block px-1 py-1"
                                         onclick="window.open('tel:{{ AppHelper::$leadNumber }}', '_self');">
                                        <div class="flex items-center">
                                            <div class="mr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     width="25"
                                                     height="25"
                                                     class="text-white"
                                                     fill="currentColor"
                                                     viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM11 .5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-4.146 4.147a.5.5 0 0 1-.708-.708L14.293 1h21.5a.5.5 0 0 1-.5-.5z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="ml-2.5 text-center">
                                                <div class="text-lg font-medium text-white">
                                                    {{ AppHelper::$leadNumber }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                     class="cursor-pointer rounded-md border-2 border-red-600 bg-white text-red-700 transition-all hover:bg-gradient-to-br hover:shadow">
                                    <div class="block px-5 py-2.5"
                                         onclick="window.open('{{ AppHelper::$leadFormLink }}', '_blank');">
                                        <div class="flex items-center">
                                            <div class="text-center text-lg font-medium">
                                                Obtenez un devis gratuit
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-1 ml-4 text-base"
                                 role="acive online">
                                <span
                                      class="mx-1 inline-block h-2.5 w-2.5 rounded-full bg-green-500"></span>
                                Expert nuisibles en ligne
                            </div>
                        </div>

                        <div class="w-full lg:w-1/2">
                            <div class="relative">
                                <img class="mx-auto max-h-[320px] rounded-md shadow-sm"
                                     src="{{ $hero->coverImage }}">
                            </div>
                        </div>
                    </div>
                </section>

                {{-- AI Description --}}
                @if (!empty($description))
                    <section
                             class="margin-responsive mx-auto my-9 lg:mt-14 lg:mb-20 lg:max-w-screen-xl">
                        <div class="mx-auto mb-10 md:pr-16">
                            <div class="mb-10 sm:text-center md:mx-auto md:mb-12">
                                <h2
                                    class="font-sans mb-6 max-w-3xl text-2xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">
                                    {{ $description->heading }}
                                </h2>
                            </div>
                            <p class="mb-6 text-lg text-gray-900">
                                {{ $description->paragraph }}
                            </p>
                            <div class="flex flex-wrap gap-10 md:mt-5 md:flex-nowrap">
                                <div
                                     class="animate-wiggle cursor-pointer rounded-md border-2 border-red-600 bg-red-600 px-4 py-2 transition-all hover:animate-none hover:bg-theme-light hover:shadow-md">
                                    <div class="block px-1 py-1"
                                         onclick="window.open('tel:{{ AppHelper::$leadNumber }}', '_self');">
                                        <div class="flex items-center">
                                            <div class="mr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     width="25"
                                                     height="25"
                                                     class="text-white"
                                                     fill="currentColor"
                                                     viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM11 .5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-4.146 4.147a.5.5 0 0 1-.708-.708L14.293 1h21.5a.5.5 0 0 1-.5-.5z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="ml-2.5 text-center">
                                                <div class="text-lg font-medium text-white">
                                                    {{ AppHelper::$leadNumber }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                     class="cursor-pointer rounded-md border-2 border-red-600 bg-white text-red-700 transition-all hover:bg-gradient-to-br hover:shadow">
                                    <div class="block px-5 py-2.5"
                                         onclick="window.open('{{ AppHelper::$leadFormLink }}', '_blank');">
                                        <div class="flex items-center">
                                            <div class="text-center text-lg font-medium">
                                                Obtenez un devis gratuit
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-1 text-base"
                                 role="acive online">
                                <span
                                      class="mx-1 inline-block h-2.5 w-2.5 rounded-full bg-green-500"></span>
                                Expert nuisibles en ligne
                            </div>
                        </div>
                    </section>
                @endif

                <!-- How it work -->
                @if (!empty($howto))
                    <section
                             class="margin-responsive mx-auto my-9 lg:mt-14 lg:mb-20 lg:max-w-screen-xl">
                        <div class="mb-10 sm:text-center md:mx-auto md:mb-12">
                            <h2
                                class="font-sans mb-6 max-w-3xl text-2xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">
                                {{ $howto->heading }}
                            </h2>
                        </div>

                        <div class="row-gap-0 grid gap-6 lg:grid-cols-4">
                            <div class="relative text-center">
                                <div
                                     class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full sm:h-20 sm:w-20">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-12 w-12 text-indigo-700 sm:h-16 sm:w-16"
                                         fill="currentColor"
                                         viewBox="0 0 16 16">
                                        <path
                                              d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h2.312Z" />
                                    </svg>
                                </div>
                                <h6 class="mb-2 text-2xl font-extrabold">
                                    Inspection
                                </h6>
                                <p class="mb-3 max-w-md text-lg text-gray-900 sm:mx-auto">
                                    {{ $howto->step->step_1 }}
                                </p>
                                <div
                                     class="top-0 right-0 flex h-10 items-center justify-center sm:h-24 lg:absolute lg:-mr-8">
                                    <svg class="w-8 rotate-90 transform text-gray-700 lg:rotate-0"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         viewBox="0 0 24 24">
                                        <line fill="none"
                                              stroke-miterlimit="10"
                                              x1="2"
                                              y1="12"
                                              x2="22"
                                              y2="12"></line>
                                        <polyline fill="none"
                                                  stroke-miterlimit="10"
                                                  points="15,5 22,12 15,19 "></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="relative text-center">
                                <div
                                     class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full sm:h-20 sm:w-20">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-12 w-12 text-indigo-700 sm:h-16 sm:w-16"
                                         fill="currentColor"
                                         viewBox="0 0 16 16">
                                        <path
                                              d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM6.646 6.24v.07H5.375v-.064c0-1.213.879-2.402 2.637-2.402 1.582 0 2.613.949 2.613 2.215 0 1.002-.6 1.667-1.287 2.43l-.096.107-1.974 2.22v.077h3.498V12H5.422v-.832l2.97-3.293c.434-.475.903-1.008.903-1.705 0-.744-.557-1.236-1.313-1.236-.843 0-1.336.615-1.336 1.306Z" />
                                    </svg>
                                </div>
                                <h6 class="mb-2 text-2xl font-extrabold">
                                    Traitement
                                </h6>
                                <p class="mb-3 max-w-md text-lg text-gray-900 sm:mx-auto">
                                    {{ $howto->step->step_2 }}
                                </p>
                                <div
                                     class="top-0 right-0 flex h-10 items-center justify-center sm:h-24 lg:absolute lg:-mr-8">
                                    <svg class="w-8 rotate-90 transform text-gray-700 lg:rotate-0"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         viewBox="0 0 24 24">
                                        <line fill="none"
                                              stroke-miterlimit="10"
                                              x1="2"
                                              y1="12"
                                              x2="22"
                                              y2="12"></line>
                                        <polyline fill="none"
                                                  stroke-miterlimit="10"
                                                  points="15,5 22,12 15,19 "></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="relative text-center">
                                <div
                                     class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full sm:h-20 sm:w-20">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-12 w-12 text-indigo-700 sm:h-16 sm:w-16"
                                         fill="currentColor"
                                         viewBox="0 0 16 16">
                                        <path
                                              d="M7.918 8.414h-.879V7.342h.838c.78 0 1.348-.522 1.342-1.237 0-.709-.563-1.195-1.348-1.195-.79 0-1.312.498-1.348 1.055H5.275c.036-1.137.95-2.115 2.625-2.121 1.594-.012 2.608.885 2.637 2.062.023 1.137-.885 1.776-1.482 1.875v.07c.703.07 1.71.64 1.734 1.917.024 1.459-1.277 2.396-2.93 2.396-1.705 0-2.707-.967-2.754-2.144H6.33c.059.597.68 1.06 1.541 1.066.973.006 1.6-.563 1.588-1.354-.006-.779-.621-1.318-1.541-1.318Z" />
                                        <path
                                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Z" />
                                    </svg>
                                </div>
                                <h6 class="mb-2 text-2xl font-extrabold">
                                    Observation
                                </h6>
                                <p class="mb-3 max-w-md text-lg text-gray-900 sm:mx-auto">
                                    {{ $howto->step->step_3 }}
                                </p>
                                <div
                                     class="top-0 right-0 flex h-10 items-center justify-center sm:h-24 lg:absolute lg:-mr-8">
                                    <svg class="w-8 rotate-90 transform text-gray-700 lg:rotate-0"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         viewBox="0 0 24 24">
                                        <line fill="none"
                                              stroke-miterlimit="10"
                                              x1="2"
                                              y1="12"
                                              x2="22"
                                              y2="12"></line>
                                        <polyline fill="none"
                                                  stroke-miterlimit="10"
                                                  points="15,5 22,12 15,19 "></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="relative text-center">
                                <div
                                     class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full sm:h-20 sm:w-20">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="currentColor"
                                         class="h-12 w-12 text-indigo-700 sm:h-16 sm:w-16"
                                         viewBox="0 0 16 16">
                                        <path
                                              d="M7.519 5.057c.22-.352.439-.703.657-1.055h1.933v5.332h1.008v1.107H10.11V12H8.85v-1.559H4.978V9.322c.77-1.427 1.656-2.847 2.542-4.265ZM6.225 9.281v.053H8.85V5.063h-.065c-.867 1.33-1.787 2.806-2.56 4.218Z" />
                                        <path
                                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Z" />
                                    </svg>
                                </div>
                                <h6 class="mb-2 text-2xl font-extrabold">
                                    Prévention
                                </h6>
                                <p class="mb-3 max-w-md text-lg text-gray-900 sm:mx-auto">
                                    {{ $howto->step->step_4 }}
                                </p>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Proven Section -->
                <section
                         class="margin-responsive mx-auto my-9 lg:mt-14 lg:mb-20 lg:max-w-screen-xl">
                    <div class="mx-auto mb-10 md:pr-16">
                        <div class="mb-10 sm:text-center md:mx-auto md:mb-12">
                            <h2
                                class="font-sans mb-6 max-w-3xl text-2xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">
                                {{ $proven->heading }}
                            </h2>
                        </div>
                        <p class="mb-6 text-lg text-gray-900">
                            {!! $proven->paragraph !!}
                        </p>
                        @if (!empty($proven->featureItem))
                            <p class="mb-6 text-lg text-gray-900">
                            <ul class="mx-5 mb-6 list-disc md:mx-11">
                                @foreach ($proven->featureItem as $item)
                                    <li class="p-0 text-lg text-gray-900 md:p-1.5">
                                        {!! $item !!}
                                    </li>
                                @endforeach
                            </ul>
                            </p>
                        @endif
                        @if (!empty($proven->content))
                            <p class="mb-6 text-lg text-gray-900">
                                {!! $proven->content !!}
                            </p>
                        @endif
                        <div class="flex flex-wrap gap-10 md:mt-5 md:flex-nowrap">
                            <div
                                 class="animate-wiggle cursor-pointer rounded-md border-2 border-red-600 bg-red-600 px-4 py-2 transition-all hover:animate-none hover:bg-theme-light hover:shadow-md">
                                <div class="block px-1 py-1"
                                     onclick="window.open('tel:{{ AppHelper::$leadNumber }}', '_self');">
                                    <div class="flex items-center">
                                        <div class="mr-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 width="25"
                                                 height="25"
                                                 class="text-white"
                                                 fill="currentColor"
                                                 viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                      d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM11 .5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-4.146 4.147a.5.5 0 0 1-.708-.708L14.293 1h21.5a.5.5 0 0 1-.5-.5z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="ml-2.5 text-center">
                                            <div class="text-lg font-medium text-white">
                                                {{ AppHelper::$leadNumber }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                 class="cursor-pointer rounded-md border-2 border-red-600 bg-white text-red-700 transition-all hover:bg-gradient-to-br hover:shadow">
                                <div class="block px-5 py-2.5"
                                     onclick="window.open('{{ AppHelper::$leadFormLink }}', '_blank');">
                                    <div class="flex items-center">
                                        <div class="text-center text-lg font-medium">
                                            Obtenez un devis gratuit
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1 text-base"
                             role="acive online">
                            <span
                                  class="mx-1 inline-block h-2.5 w-2.5 rounded-full bg-green-500"></span>
                            Expert nuisibles en ligne
                        </div>
                    </div>
                </section>

                <!-- Tips -->
                @if (!empty($tips))
                    <section
                             class="margin-responsive mx-auto my-9 lg:mb-20 lg:max-w-screen-xl">
                        <div class="mb-10 md:mb-12">
                            <h2
                                class="font-sans mb-6 text-2xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl">
                                {{ $tips->heading }}
                            </h2>
                            @if (!empty($tips->paragraph))
                                <p class="text-lg text-gray-700 md:text-lg">
                                    {{ $tips->paragraph }}
                                </p>
                            @endif
                            @if (!empty($tips->featureItem))
                                <p class="mb-6 text-lg text-gray-900">
                                <ul class="ml-6 list-disc">
                                    @foreach ($tips->featureItem as $item)
                                        <li class="my-3 text-lg text-gray-900">
                                            {!! $item !!}
                                        </li>
                                    @endforeach
                                </ul>
                                </p>
                            @endif
                            @if (!empty($tips->content))
                                <p class="mb-6 text-lg text-gray-900">
                                    {!! $tips->content !!}
                                </p>
                            @endif
                        </div>
                    </section>
                @endif

                <!-- Treatment -->
                @if (!empty($treatment))
                    <section
                             class="margin-responsive mx-auto md:my-9 lg:mt-14 lg:mb-20 lg:max-w-screen-xl">
                        <div
                             class="mb-10 max-w-4xl sm:text-center md:mx-auto md:mb-12 lg:max-w-2xl">
                            <h2
                                class="font-sans mb-6 max-w-3xl text-2xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">
                                {{ $treatment->heading }}
                            </h2>
                            <p class="mb-6 text-lg text-gray-900">
                                {{ $treatment->paragraph }}
                            </p>
                        </div>
                        <div
                             class="mx-auto grid max-w-screen-lg space-y-6 lg:grid-cols-2 lg:space-y-0 lg:divide-x">
                            <div class="flex max-w-xl flex-col sm:flex-row md:pr-10">
                                <div>
                                    <b class="mb-5 text-xl font-bold leading-5">
                                        {{ $treatment->before->title }}
                                    </b>
                                    <ul class="mb-4 -ml-1 space-y-2 text-lg">
                                        @foreach ($treatment->before->item as $item)
                                            <li class="flex items-start">
                                                <span class="mr-1 mt-1">
                                                    <svg class="mt-px h-5 w-5 text-indigo-700"
                                                         stroke="currentColor"
                                                         viewBox="0 0 52 52">
                                                        <polygon stroke-width="4"
                                                                 stroke-linecap="round"
                                                                 stroke-linejoin="round"
                                                                 fill="none"
                                                                 points="29 13 14 29 25 29 23 39 38 23 27 23">
                                                        </polygon>
                                                    </svg>
                                                </span>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="flex max-w-xl flex-col sm:flex-row md:pl-10">
                                <div class="">
                                    <b class="mb-5 text-xl font-bold leading-5">
                                        {{ $treatment->after->title }}
                                    </b>
                                    <ul class="mb-4 -ml-1 space-y-2 text-lg">
                                        @foreach ($treatment->after->item as $item)
                                            <li class="flex items-start">
                                                <span class="mr-1 mt-1">
                                                    <svg class="mt-px h-5 w-5 text-indigo-700"
                                                         stroke="currentColor"
                                                         viewBox="0 0 52 52">
                                                        <polygon stroke-width="4"
                                                                 stroke-linecap="round"
                                                                 stroke-linejoin="round"
                                                                 fill="none"
                                                                 points="29 13 14 29 25 29 23 39 38 23 27 23">
                                                        </polygon>
                                                    </svg>
                                                </span>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- country map -->
                @if (!empty($map))
                    <section
                             class="margin-responsive mx-auto my-9 lg:mt-14 lg:mb-20 lg:max-w-screen-xl">
                        <div class="relative md:pb-12">
                            <div class="mx-auto text-center">
                                <h2
                                    class="font-sans mb-6 max-w-3xl text-2xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">
                                    {{ $map->heading }}
                                </h2>
                            </div>
                            <div class="md:mt-8">
                                <div class="block w-8/12 gap-3 md:py-5 lg:mt-5">
                                    <div class="flex w-full gap-3">
                                        <div class="w-full">
                                            <ul
                                                class="!m-0 !list-none columns-2 text-lg md:gap-x-4">
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'marseille']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Marseille
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'lyon']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Lyon
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'toulouse']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Toulouse
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'nice']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Nice
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'nantes']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Nantes
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'montpellier']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Montpellier
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'strasbourg']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Strasbourg
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'bordeaux']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Bordeaux
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'lille']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Lille
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'rennes']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Rennes
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'reims']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Reims
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'saint-etienne']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Saint-Étienne
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'le-havre']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Le Havre
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'toulon']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Toulon
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'grenoble']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Grenoble
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'dijon']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Dijon
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'angers']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Angers
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'nimes']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Nîmes
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'villeurbanne']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Villeurbanne
                                                    </a>
                                                </li>
                                                <li
                                                    class="!mr-3 border-b border-gray-300 !px-0 !py-2.5 text-lg font-normal">
                                                    <a href="{{ route('service.page', ['service' => request()->route('service'), 'city' => 'le-mans']) }}"
                                                       class="hover:text-blue-800">
                                                        {{ $map->label }} Le Mans
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mx-auto mt-10 text-center">
                                        <a href=" {{ route('service.coverage', ['service' => request()->route('service')]) }} "
                                           class="inline-block cursor-pointer rounded-md border-2 border-red-600 bg-white px-5 py-2.5 text-center text-lg font-medium text-red-700 transition-all hover:bg-gradient-to-br hover:shadow">
                                            Voir toutes les villes et régions
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Company List --}}
                @if (isset($company->show) != 'no' && !empty($companies))
                    <section
                             class="margin-responsive mx-auto my-9 lg:mt-14 lg:mb-20 lg:max-w-screen-xl">
                        <div class="sm:py-3 sm:px-5">
                            <h2
                                class="font-sans mb-4 text-2xl font-bold leading-none tracking-tight text-gray-900">
                                {{ $company->title }} {{ count($companies) }}
                            </h2>
                            <hr class="mb-3 text-gray-700" />
                            <p class="mb-6 text-lg text-gray-800">
                                Liste informative et aléatoire : certaines entreprises ne font
                                pas
                                partie du réseau de partenaires Blanee.com
                            </p>
                            <div class="my-4">
                                @foreach ($companies as $item)
                                    <div
                                         class="my-5 block gap-10 text-gray-700 md:my-2 md:flex">
                                        <p
                                           class="w-full border-solid border-gray-200 text-lg font-light md:border-b md:py-1.5">
                                            {{ $item['business_name'] }}
                                        </p>
                                        <address
                                                 class="w-full border-b border-solid border-gray-200 pb-3 text-sm font-light md:py-1.5 md:text-lg">
                                            {{ $item['business_address'] }}
                                            {{ $item['city_code'] }}
                                            {{ $item['city_name'] }}
                                        </address>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Others Category suggestion --}}
                @if (isset($suggestion) != 'no')
                    <section
                             class="margin-responsive mx-auto my-9 lg:mt-14 lg:mb-20 lg:max-w-screen-xl">
                        <div class="mb-4 md:mb-8">
                            <h2
                                class="font-sans mb-6 text-left text-2xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl">
                                Nos autres services à {{ $city['city_name'] }} :
                            </h2>
                        </div>

                        <div class="">
                            <div class="grid grid-cols-1 gap-2.5 lg:grid-cols-4">

                                @foreach ($service as $item)
                                    <div
                                         class="group mr-2 mb-2 max-w-xs cursor-pointer rounded border border-gray-200 bg-white p-8 shadow-lg transition-all hover:shadow-xl">
                                        <a href="{{ route('service.page', ['service' => $item->url, 'city' => $city['city_slug']]) }}"
                                           class="relative text-center">
                                            <div
                                                 class="mx-auto mb-4 flex items-center justify-center rounded-full group-hover:animate-in sm:h-20 sm:w-20 md:h-28 md:w-28">
                                                <img src="{{ $item->icon }}" />
                                            </div>
                                            <p
                                               class="mb-2 text-xl font-medium group-hover:text-blue-800">
                                                {{ $item->name }}
                                            </p>
                                            <div class="mx-auto mt-3 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     fill="currentColor"
                                                     class="bi bi-arrow-right-short m-auto h-14 w-14 text-blue-600 group-hover:animate-shake group-hover:text-blue-800"
                                                     viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </section>
                @endif

                <!-- FAQ -->
                <section
                         class="margin-responsive mx-auto my-9 lg:mt-14 lg:mb-20 lg:max-w-screen-xl">
                    <div class="max-w-xl sm:mx-auto lg:max-w-2xl">
                        <div
                             class="mb-4 max-w-xl sm:text-center md:mx-auto md:mb-12 lg:max-w-2xl">
                            <h2
                                class="font-sans mb-6 max-w-lg text-2xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">
                                {{ $faq->heading }}
                            </h2>
                        </div>
                    </div>
                    <div class="max-w-screen-xl sm:mx-auto md:px-20">
                        <div class="columns-2 text-lg">
                            @foreach ($faq->item as $item)
                                <div class="mt-6 inline-block">
                                    <h3 role="question"
                                        class="mb-2 text-lg font-bold md:mb-4 md:text-xl">
                                        {{ $item->title }}
                                    </h3>
                                    <p role="answer"
                                       class="text-gray-700">
                                        {{ $item->paragraph }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <!-- blog artices suggest -->
                @if (!empty($blog))
                    <section
                             class="margin-responsive mx-auto my-9 lg:mt-14 lg:mb-20 lg:max-w-screen-xl">
                        <div
                             class="mb-10 max-w-xl sm:text-center md:mx-auto md:mb-12 lg:max-w-2xl">
                            <h2
                                class="font-sans mb-6 max-w-lg text-2xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">
                                {{ $blog->heading }}
                            </h2>
                            <p class="mb-6 text-lg text-gray-900">
                                {{ $blog->paragraph }}
                            </p>
                        </div>
                        <div
                             class="mt-3 grid grid-cols-1 gap-8 pb-8 lg:grid-cols-3 lg:px-16">
                            @foreach ($blog->post as $post)
                                @include(
                                    'public.post.partials.card',
                                    compact('post'))
                            @endforeach
                        </div>
                        <div class="mx-auto text-center">
                            <a href="{{ route('category', ['category' => $blog->category]) }}"
                               class="mt-1 mb-8 inline-flex items-center rounded-lg bg-theme-color px-3 py-1.5 text-base capitalize text-white hover:bg-theme-light">
                                {{ $blog->button }}
                                <svg aria-hidden="true"
                                     class="ml-2 -mr-1 h-5 w-5"
                                     fill="currentColor"
                                     viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h21.586l-4.293-4.293a1 1 0 010-1.414z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </section>
                @endif

                <!-- Band logo -->
                <section
                         class="margin-responsive mx-auto my-9 lg:mt-14 lg:mb-20 lg:max-w-screen-xl">
                    <div class="lg:px-8 lg:pb-12">
                        <div class="-mx-4">
                            <div class="mx-auto text-center md:px-4">
                                <img class="m-auto max-w-[14rem] md:max-w-sm"
                                     src="{{ asset('assets/public/img/logo-certibiocide.png') }}" />
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Call To Action -->
                <section class="pt-5">
                    <div class="mx-auto">
                        <div
                             class="relative overflow-hidden bg-[#4b5563] py-12 px-8 md:p-[70px]">
                            <div class="-mx-4">
                                <div class="mx-auto px-4 text-center">
                                    <h2
                                        class="mb-3 text-3xl font-bold leading-tight text-white sm:mb-8 sm:ml-6 md:text-3xl lg:mb-0">
                                        Prêt à prendre RDV maintenant ?
                                    </h2>
                                </div>
                                <div
                                     class="mt-8 flex flex-wrap justify-center gap-10 md:mt-12 md:ml-5 md:flex-nowrap">
                                    <div
                                         class="animate-wiggle cursor-pointer rounded-md border-2 border-red-600 bg-red-600 px-4 py-2 transition-all hover:animate-none hover:bg-theme-light hover:shadow-md">
                                        <div class="block px-1 py-1"
                                             onclick="window.open('tel:{{ AppHelper::$leadNumber }}', '_self');">
                                            <div class="flex items-center">
                                                <div class="mr-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         width="25"
                                                         height="25"
                                                         class="text-white"
                                                         fill="currentColor"
                                                         viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                              d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM11 .5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-4.146 4.147a.5.5 0 0 1-.708-.708L14.293 1h21.5a.5.5 0 0 1-.5-.5z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="ml-2.5 text-center">
                                                    <div
                                                         class="text-lg font-medium text-white">
                                                        {{ AppHelper::$leadNumber }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                         class="cursor-pointer rounded-md border-2 border-red-600 bg-white text-red-700 transition-all hover:bg-gradient-to-br hover:shadow">
                                        <div class="block px-5 py-2.5"
                                             onclick="window.open('{{ AppHelper::$leadFormLink }}', '_blank');">
                                            <div class="flex items-center">
                                                <div class="text-center text-lg font-medium">
                                                    Obtenez un devis gratuit
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <span class="absolute top-0 left-0 z-[-1]">
                                    <svg width="189"
                                         height="162"
                                         viewBox="0 0 189 162"
                                         fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <ellipse cx="16"
                                                 cy="-16.5"
                                                 rx="173"
                                                 ry="178.5"
                                                 transform="rotate(180 16 -16.5)"
                                                 fill="url(#paint0_linear)" />
                                        <defs>
                                            <linearGradient id="paint0_linear"
                                                            x1="-157"
                                                            y1="-107.754"
                                                            x2="98.5011"
                                                            y2="-106.425"
                                                            gradientUnits="userSpaceOnUse">
                                                <stop stop-color="white"
                                                      stop-opacity="0.07" />
                                                <stop offset="1"
                                                      stop-color="white"
                                                      stop-opacity="0" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </span>
                                <span class="absolute bottom-0 right-0 z-[-1]">
                                    <svg width="191"
                                         height="208"
                                         viewBox="0 0 191 208"
                                         fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <ellipse cx="173"
                                                 cy="178.5"
                                                 rx="173"
                                                 ry="178.5"
                                                 fill="url(#paint0_linear)" />
                                        <defs>
                                            <linearGradient id="paint0_linear"
                                                            x1="-3.27832e-05"
                                                            y1="87.2457"
                                                            x2="255.501"
                                                            y2="88.5747"
                                                            gradientUnits="userSpaceOnUse">
                                                <stop stop-color="white"
                                                      stop-opacity="0.07" />
                                                <stop offset="1"
                                                      stop-color="white"
                                                      stop-opacity="0" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </section>
    </main>
@endsection
