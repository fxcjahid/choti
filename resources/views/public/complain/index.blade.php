@extends('public.app')

@section('title', trans('complain.title'))
@section('canonical', route('complain.index'))
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
                        অভিযোগ করুন
                    </h1>
                    <p class="mb-8 mt-8 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                        এই সাইটে, আপনার নিরাপত্তা এবং গোপনীয়তা আমাদের শীর্ষ অগ্রাধিকার। আমরা মত প্রকাশের স্বাধীনতাকে
                        মূল্যবান মনে করি কিন্তু অবৈধ বিষয়বস্তু, অ-সম্মতিমূলক উপাদান এবং শিশু যৌন নির্যাতন উপাদান (সিএসএএম)
                        এর জন্য আমাদের শূন্য সহনশীলতা রয়েছে।
                    </p>
                    <h2 class="mb-3 text-xl font-extrabold text-slate-900">
                        আপত্তিজনক বা অবৈধ সামগ্রীর প্রতিবেদন করুন
                    </h2>
                    <p class="mb-2 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                        অনুগ্রহ করে নীচের ফর্মটি পূরণ করুন যদি আপনি এর শিকার হন, বা এমন সামগ্রীর মুখোমুখি হন যা গঠন হিসাবে
                        আপনার ব্যক্তিগত জ্ঞান রয়েছে:
                    </p>
                    <ul class="ml-10 mb-10 list-disc text-lg">
                        <li class="mb-2">
                            অ-সম্মতিপূর্ণ তৈরি কন্টেন এবং অথবা আপনার ইমেজ বিতরণ ( উদাহরণঃ প্রতিশোধ অশ্লীল, ব্ল্যাকমেইল,
                            শোষণ)
                        </li>
                        <li class="mb-2">
                            বিষয়বস্তু যা ব্যক্তিগতভাবে সনাক্তকরণযোগ্য তথ্য প্রকাশ করে (যেমন নাম, ঠিকানা, ফোন নম্বর,
                            ইত্যাদি)
                        </li>
                        <li class="mb-2">
                            অন্য কোনও আপত্তিজনক তথ্য এবং অথবা অবৈধ পোস্ট বা ছবি ইত্যাদি
                        </li>
                    </ul>

                    <form action="{{ route('complain.store') }}" method="post" class="space-y-8">
                        {{ csrf_field() }}
                        <div>
                            <label for="post_url" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                পোষ্ট লিংক দিন <span class="text-red-600 font-black">*</span>
                            </label>
                            <input type="text" id="post_url" name="post_url" value="{{ old('post_url') }}"
                                class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            @if ($errors->has('post_url'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('post_url') }}
                                </div>
                            @endif
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-400">
                                কেন মনে করেন এই পোষ্ট রিমুভ করা প্রয়োজন ? <span class="text-red-600 font-black">*</span>
                            </label>
                            <textarea id="message" rows="6" name="message"
                                class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">{{ old('message') }}</textarea>
                            @if ($errors->has('message'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('message') }}
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
                            class="mt-2 rounded-lg bg-theme-color py-2 px-5 text-center text-lg font-medium text-white outline-none hover:bg-theme-light dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit">
                            সাবমিট করুন
                        </button>
                    </form>
                </div>
            </section>
            {!! GoogleReCaptchaV3::init() !!}
        </div>
    </main>

@endsection
