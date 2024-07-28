@extends('public.app')

@section('title', 'বাংলা চটি গল্প লিখে পাঠান')
@section('canonical', route('submit.story'))
@section('content')
    <main class="">
        <div class="2xl:m-auto 2xl:max-w-screen-2xl">
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

                    <h1 class="mb-3 text-center font-trebuchet text-[30px] font-extrabold text-slate-900">
                        বাংলা চটি গল্প লিখে পাঠান
                    </h1>
                    <p class="mb-8 mt-8 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                        বাংলায় লিখিত সমস্ত চটি লেখক বা লেখিকাদের প্রতি আমাদের বিনীত অনুরোধ আপনারা দয়া করে বাংলায় লেখা চটি
                        গল্প আমাদের লিখে পাঠান। সর্বদায় আমরা নতুন ট্যালেন্টদের প্রমোট করার চেস্টা করি তাই নতুন লেখক বা
                        লেখিকাদেরও আমরা আমন্ত্রন জানায়।
                    </p>
                    <p class="mb-8 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                        আপনার গল্প জমা দেওয়ার জন্য নীচের ফর্মটি ব্যবহার করুন – বিকল্পভাবে আপনি আপনার গল্প মেইল করতে পারেন
                        <b>debjani.ipe@gmail.com</b>
                    </p>
                    <p class="mb-8 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                        বাংলায় টাইপ করুন (Desktop) থেকে –
                        <a href="https://www.google.com/intl/bn/inputtools/try/" target="_blank"
                            class="font-bold text-blue-600 hover:underline" rel="noopener noreferrer">
                            ক্লিক করুন
                        </a>
                    </p>
                    <form action="{{ route('contact.store') }}" method="post" class="space-y-8">
                        {{ csrf_field() }}
                        <div>
                            <label for="title" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                টাইটেল লিখুন <span class="text-red-600 font-black">*</span>
                            </label>
                            <input type="text" id="title" name="phone" value="{{ old('title') }}"
                                class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            @if ($errors->has('title'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>
                        <div class="sm:col-span-2">
                            <label for="content" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-400">
                                মুল গল্প লিখুন <span class="text-red-600 font-black">*</span>
                            </label>
                            <textarea id="content" rows="6" name="content"
                                class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">{{ old('content') }}</textarea>
                            @if ($errors->has('content'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('content') }}
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-between gap-4">
                            <div class="w-full">
                                <label for="name"
                                    class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                    আপনার নাম (অপশনালঃ)
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                @if ($errors->has('name'))
                                    <div class="text-base font-medium text-red-600">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="w-full">
                                <label for="email"
                                    class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                    আপনার ইমেইল (অপশনালঃ)
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                @if ($errors->has('email'))
                                    <div class="text-base font-medium text-red-600">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="!mt-2 sm:col-span-2 hidden">
                            <p class="font-nato text-sm text-gray-600">
                                Ce site Web est protégé par reCAPTCHA et la <a rel="nofollow"
                                    class="text-blue-700 underline" target="_blank"
                                    href="https://policies.google.com/privacy">Politique de
                                    Confidentialité</a> et les <a rel="nofollow" class="text-blue-700 underline"
                                    target="_blank" href="https://policies.google.com/terms">Conditions Générales
                                    d'Utilisation</a> de Google sont applicables.
                            </p>
                        </div>
                        {!! GoogleReCaptchaV3::renderField('contact_us_id', 'contact_us_action') !!}
                        <button type="submit"
                            class="!-mt-0.5 rounded-lg bg-theme-color py-2 px-5 text-center text-lg font-medium text-white outline-none hover:bg-theme-light dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit">
                            সাবমিট করুন
                        </button>
                    </form>
                </div>
            </section>
            {!! GoogleReCaptchaV3::init() !!}
        </div>
    </main>

@endsection
