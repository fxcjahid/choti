@extends('public.app')

@section('title', 'Nous contacter - Blanee.com')
@section('canonical', route('contact.index'))

@section('content')
    <main class="">

        <section class="bg-white dark:bg-gray-900">
            <div class="mx-auto max-w-screen-md py-8 px-4 lg:py-16">

                @include('public.components.errors.alert')

                @if (Session::has('success'))
                    <div class="alert alert-success mb-10">
                        {!! Session::get('success') !!}
                        @php
                            Session::forget('success');
                        @endphp
                    </div>
                @endif

                <h1
                    class="mb-3 text-center font-trebuchet text-[30px] font-extrabold text-slate-900">
                    ☎️ Besoin d’aide ?
                </h1>
                <p class="mb-8 mt-8 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                    Notre équipe se tient prête pour vous aider 24h/24 7j/7 par téléphone au
                    {{ AppHelper::$leadNumber }}, par chat ou par email ci-dessous !
                </p>
                <p class="mb-8 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                    Si vous avez une question sur les nuisibles, nous vous recommandons de
                    lire nos nombreux guides couvrant la majorité des parasites.
                </p>
                <form action="{{ route('contact.store') }}"
                      method="post"
                      class="space-y-8">
                    {{ csrf_field() }}
                    <div class="flex justify-between gap-4">
                        <div class="w-full">
                            <label for="name"
                                   class="mb-2 block text-base font-medium text-gray-900 dark:text-gray-300">
                                Nom
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="block w-full rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            @if ($errors->has('name'))
                                <div class="text-sm font-medium text-red-600">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="w-full">
                            <label for="email"
                                   class="mb-2 block text-base font-medium text-gray-900 dark:text-gray-300">
                                Email
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="block w-full rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            @if ($errors->has('email'))
                                <div class="text-sm font-medium text-red-600">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label for="phone"
                               class="mb-2 block text-base font-medium text-gray-900 dark:text-gray-300">
                            Numéro de téléphone
                        </label>
                        <input type="text"
                               id="phone"
                               name="phone"
                               value="{{ old('phone') }}"
                               class="block w-full rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        @if ($errors->has('phone'))
                            <div class="text-sm font-medium text-red-600">
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
                    </div>
                    <div class="sm:col-span-2">
                        <label for="message"
                               class="mb-2 block text-base font-medium text-gray-900 dark:text-gray-400">
                            Message
                        </label>
                        <textarea id="message"
                                  rows="6"
                                  name="message"
                                  class="block w-full rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">{{ old('message') }}</textarea>
                        @if ($errors->has('message'))
                            <div class="text-sm font-medium text-red-600">
                                {{ $errors->first('message') }}
                            </div>
                        @endif
                    </div>
                    <div class="!mt-2 sm:col-span-2">
                        <p class="font-nato text-sm text-gray-600">
                            Ce site Web est protégé par reCAPTCHA et la <a rel="nofollow"
                               class="text-blue-700 underline"
                               target="_blank"
                               href="https://policies.google.com/privacy">Politique de
                                Confidentialité</a> et les <a rel="nofollow"
                               class="text-blue-700 underline"
                               target="_blank"
                               href="https://policies.google.com/terms">Conditions Générales
                                d'Utilisation</a> de Google sont applicables.
                        </p>
                    </div>
                    {!! GoogleReCaptchaV3::renderField('contact_us_id', 'contact_us_action') !!}
                    <button type="submit"
                            class="!-mt-3 rounded-lg bg-theme-color py-2 px-5 text-center text-base font-medium text-white outline-none hover:bg-gray-700 dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit">
                        Envoyer
                    </button>
                </form>
            </div>
        </section>
        {!! GoogleReCaptchaV3::init() !!}
    </main>
@endsection
