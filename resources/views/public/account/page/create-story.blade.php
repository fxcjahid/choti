@extends('public.account.index')
@section('title', 'নতুন গল্প লিখুন')
@section('subcontent')
    <div class="profile-edits">
        <div class="mb-5 border-b border-gray-100">
            <h1 class="mb-3 text-xl md:text-2xl text-slate-900">
                বাংলা চটি গল্প লেখুন
            </h1>
        </div>
        <div class="my-5 mx-5">
            <p class="mb-8 mt-8 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                বাংলায় লিখিত সমস্ত চটি লেখক বা লেখিকাদের প্রতি আমাদের বিনীত অনুরোধ আপনারা দয়া করে বাংলায় লেখা চটি
                গল্প আমাদের লিখে পাঠান। সর্বদায় আমরা নতুন ট্যালেন্টদের প্রমোট করার চেস্টা করি তাই নতুন লেখক বা
                লেখিকাদেরও আমরা আমন্ত্রন জানায়।
            </p>
            <p class="mb-8 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                আপনার গল্প জমা দেওয়ার জন্য নীচের ফর্মটি ব্যবহার করুন – বিকল্পভাবে আপনি আপনার গল্প মেইল করতে পারেন
                <b>allchotigolpo.me@gmail.com</b>
            </p>
            <p class="mb-8 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                বাংলায় টাইপ করুন (Desktop) থেকে –
                <a href="https://www.google.com/intl/bn/inputtools/try/" target="_blank"
                    class="font-bold text-blue-600 hover:underline" rel="noopener noreferrer">
                    ক্লিক করুন
                </a>
            </p>
            <form action="{{ route('public.story.store') }}" method="post" class="space-y-8">
                {{ csrf_field() }}
                <div>
                    <label for="title" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                        টাইটেল লিখুন <span class="text-red-600 font-black">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
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


                {!! GoogleReCaptchaV3::renderField('contact_us_id', 'contact_us_action') !!}
                <button type="submit"
                    class="!-mt-0.5 rounded-lg bg-theme-color py-2 px-5 text-center text-lg font-medium text-white outline-none hover:bg-theme-light dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit">
                    সাবমিট করুন
                </button>
            </form>
        </div>
    </div>
@endsection
