@extends('public.app')


{{ Meta::setTitle('যোগাযোগ করুন') }}


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

                <h1 class="mb-3 text-center font-trebuchet text-[30px] font-extrabold text-slate-900">
                    যোগাযোগ করুন
                </h1>
                <p class="mb-8 mt-8 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                    আপনার বক্তব্য বা মত্তব জানানোর দেওয়ার আগে প্রথমে আমাদের “প্রায়শই জিজ্ঞাসিত প্রশ্নাবলী এবং উত্তর”
                    পৃষ্ঠাটি দেখে আসতে পারেন । আপনার প্রশ্নের উত্তর হয়ত এখানেই পেয়ে যেতে পারেন! – “প্রায়শই জিজ্ঞাসিত
                    প্রশ্নাবলী এবং উত্তর” পৃষ্ঠা দেখার জন্য এখানে ক্লিক করুন
                </p>
                <form action="{{ route('contact.store') }}" method="post" class="space-y-8">
                    {{ csrf_field() }}
                    <div class="md:flex space-y-6 justify-between gap-4">
                        <div class="w-full">
                            <label for="name" class="mb-2 block text-base font-medium text-gray-900 dark:text-gray-300">
                                আপনার নাম <span class="text-red-600 font-black">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="block w-full rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            @if ($errors->has('name'))
                                <div class="text-sm font-medium text-red-600">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="w-full">
                            <label for="email" class="mb-2 block text-base font-medium text-gray-900 dark:text-gray-300">
                                আপনার ইমেইল <span class="text-red-600 font-black">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="block w-full rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            @if ($errors->has('email'))
                                <div class="text-sm font-medium text-red-600">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="message" class="mb-2 block text-base font-medium text-gray-900 dark:text-gray-400">
                            মুল বক্তব্য বা মত্তব লিখুন <span class="text-red-600 font-black">*</span>
                        </label>
                        <textarea id="message" rows="6" name="message"
                            class="block w-full rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">{{ old('message') }}</textarea>
                        @if ($errors->has('message'))
                            <div class="text-sm font-medium text-red-600">
                                {{ $errors->first('message') }}
                            </div>
                        @endif
                    </div>
                    <div class="!mt-2.5 sm:col-span-2">
                        <p class="text-sm text-gray-600">
                            এই ওয়েবসাইটটি reCAPTCHA দ্বারা সুরক্ষিত এবং Google <a rel="nofollow"
                                class="text-blue-700 underline" target="_blank"
                                href="https://policies.google.com/privacy">গোপনীয়তা নীতি</a> এবং <a rel="nofollow"
                                class="text-blue-700 underline" target="_blank"
                                href="https://policies.google.com/terms">পরিষেবার শর্তাবলী</a>
                            প্রযোজ্য৷
                        </p>
                    </div>
                    {!! GoogleReCaptchaV3::renderField('contact_us_id', 'contact_us_action') !!}
                    <button type="submit"
                        class="!-mt-1 rounded-lg bg-theme-color py-2 px-5 text-center text-lg font-medium text-white outline-none hover:bg-theme-light dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit">
                        সাবমিট করুন
                    </button>
                </form>
            </div>
        </section>

    </main>
@endsection
