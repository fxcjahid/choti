@extends('public.app')

@section('title', trans('story.title'))
@section('canonical', route('public.story.index'))
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

                    <div class="alert alert-danger mb-20 text-xl">
                        সতর্কীকরণ : এই গল্পের এক্সেস টি ব্রাউজার কুকি থেকে দেখানো হচ্ছে। যদি কোনো কারনে কুকি রিমুভ হয়ে যায়
                        তাহলে আর আপনি এই গল্পের এক্সেস পাবেন না
                    </div>

                    <div class="alert alert-info mt-10 mb-10 text-xl">
                        ধন্যবাদ ! আপনার গল্প ইতিমধে স্টোর করা হয়েছে। অপেক্ষা করুন সম্পন্ন পাবলিশ হবার জন্য
                    </div>

                    <p class="my-10 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                        এই গল্পের এডিটোর বা মালিকানা ধরে রাখতে নিচে আপনার নাম এবং ইমেইল এড্রেস দিয়ে ইমেইল ভেরিফিকেশন করুন
                        কিংবা <b>নতুন একাউন্ট খুলুন</b> বা <b>লগইন</b> করে এক্সেস গ্রহন করুন
                    </p>
                    <hr class="my-10 !border-t-0 border-b border-gray-200" />

                    <form action="{{ route('public.story.store') }}" method="post" class="space-y-8">
                        {{ csrf_field() }}
                        <div>
                            <div class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                গল্পের টাইটেলঃ
                            </div>
                            <p
                                class="block w-full rounded-md border cursor-no-drop border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                রেইড স্প্রে কীটনাশক কি বিছানার পোকা মেরে ফেলে?
                            </p>
                            <div class="text-sm my-0.5 font-normal text-gray-600">
                                গল্পের নাম পরিবর্তন করতে চাইলে, অবশ্যই এক্সেস ভেরিফিকেশন করতে হবে
                            </div>
                        </div>

                        <div class="flex justify-between gap-4">
                            <div class="w-full">
                                <label for="name"
                                    class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                    আপনার নামঃ
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
                                    আপনার ইমেইলঃ
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

                        <div>
                            <label for="title" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                ক্যাটাগরি সেলেক্ট বা লিখুনঃ <span class="text-gray-600 font-light">(অপশনাল)</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            @if ($errors->has('title'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="title" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                সেরিজ সেলেক্ট বা লিখুনঃ <span class="text-gray-600 font-light">(অপশনাল)</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            @if ($errors->has('title'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="title" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                ট্যাগ সেলেক্ট বা লিখুনঃ <span class="text-gray-600 font-light">(অপশনাল)</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            @if ($errors->has('title'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="title" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                ইমেজ আপলোড করুনঃ <span class="text-gray-600 font-light">(অপশনাল)</span>
                            </label>
                            <input type="file" id="title" name="title" value="{{ old('title') }}"
                                class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            @if ($errors->has('title'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>

                        {!! GoogleReCaptchaV3::renderField('contact_us_id', 'contact_us_action') !!}
                        <button type="submit"
                            class="!-mt-0.5 rounded-lg bg-theme-color py-2 px-5 text-center text-lg font-medium text-white outline-none hover:bg-theme-light dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit">
                            আপডেট করুন
                        </button>
                    </form>
                </div>
            </section>
            {!! GoogleReCaptchaV3::init() !!}
        </div>
    </main>

@endsection
