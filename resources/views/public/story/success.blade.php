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
                        <div class="alert alert-success !mb-16 text-xl">
                            {!! Session::get('success') !!}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @endif

                    @guest
                        <div class="alert alert-danger mb-20 text-xl">
                            সতর্কীকরণ : এই গল্পের এক্সেস টি ব্রাউজার কুকি থেকে দেখানো হচ্ছে। যদি কোনো কারনে কুকি রিমুভ হয়ে যায়
                            তাহলে আর আপনি এই গল্পের এক্সেস পাবেন না
                        </div>
                    @endguest

                    <div class="alert alert-info mt-10 mb-10 text-xl">
                        ধন্যবাদ ! আপনার গল্প ইতিমধে স্টোর করা হয়েছে। অপেক্ষা করুন সম্পন্ন পাবলিশ হবার জন্য
                    </div>

                    @auth
                        <p class="my-10 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                            অনুগ্রহ করে নিচের ফর্মটি ফিলাপ করে সাহায্য করুন
                        </p>
                    @endauth

                    @guest
                        <p class="my-10 font-nato text-lg font-normal text-slate-900 sm:mx-auto">
                            এই গল্পের এডিটোর বা মালিকানা ধরে রাখতে নিচে আপনার নাম এবং ইমেইল এড্রেস দিয়ে ইমেইল ভেরিফিকেশন
                            করুন কিংবা
                            <a href="{{ route('public.auth.index', ['tab' => 'signup']) }}" class="font-semibold text-blue-800">
                                নতুন একাউন্ট খুলুন
                            </a> বা
                            <a href="{{ route('public.auth.index', ['tab' => 'login']) }}" class="font-semibold text-blue-800">
                                লগইন
                            </a> করে এক্সেস গ্রহন করুন
                        </p>
                    @endguest

                    <hr class="my-10 !border-t-0 border-b border-gray-200" />

                    <form action="{{ route('public.story.update', ['id' => $post->id]) }}" enctype="multipart/form-data"
                        method="post" class="space-y-8">
                        {{ csrf_field() }}
                        <div>
                            <label for="title" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                গল্পের টাইটেলঃ
                            </label>
                            @guest
                                <p
                                    class="block w-full rounded-md border cursor-no-drop border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                    {{ $post->title }}
                                </p>
                                <div class="text-sm my-0.5 font-normal text-gray-600">
                                    গল্পের নাম পরিবর্তন করতে চাইলে, অবশ্যই এক্সেস ভেরিফিকেশন করতে হবে
                                </div>
                                <input type="hidden" id="title" name="title" value="{{ $post->title }}" class="hidden">
                                <input type="hidden" id="content" name="content" value="{{ $post->content }}" class="hidden">
                            @endguest
                            @auth
                                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                                    class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                @if ($errors->has('title'))
                                    <div class="text-base font-medium text-red-600">
                                        {{ $errors->first('title') }}
                                    </div>
                                @endif
                            @endauth
                        </div>

                        @guest
                            <div class="md:flex space-y-6 justify-between gap-4">
                                <div class="w-full">
                                    <label for="name"
                                        class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                        আপনার নামঃ
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $post->name) }}"
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
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $post->email) }}"
                                        class="block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                    @if ($errors->has('email'))
                                        <div class="text-base font-medium text-red-600">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endguest

                        <div>
                            <label for="category" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                ক্যাটাগরি সেলেক্ট বা লিখুনঃ <span class="text-gray-600 font-light">(অপশনাল)</span>
                            </label>
                            <select id="category" name="category[]" multiple
                                class="block w-full tom-select rounded-md border border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">

                                @foreach ($category as $category)
                                    <option value="{{ $category->id }}" @if (in_array($category->id, old('category', $post->category->pluck('id')->toArray()))) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                            @if ($errors->has('category'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('category') }}
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="series" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                সেরিজ সেলেক্ট বা লিখুনঃ <span class="text-gray-600 font-light">(অপশনাল)</span>
                            </label>
                            <select id="series" name="series"
                                class="block w-full tom-select rounded-md border border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                <option value="" selected></option>
                                @foreach ($series as $series)
                                    <option value="{{ $series->id }}"
                                        {{ old('series', $post->series[0]->id ?? null) == $series->id ? 'selected' : '' }}>
                                        {{ $series->name }}
                                    </option>
                                @endforeach

                            </select>
                            @if ($errors->has('series'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('series') }}
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="tags" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                ট্যাগ সেলেক্ট বা লিখুনঃ <span class="text-gray-600 font-light">(অপশনাল)</span>
                            </label>
                            <select id="tags" name="tags[]" multiple
                                class="block w-full tom-select rounded-md border border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">

                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" @if (in_array($tag->id, old('tags', $post->tag->pluck('id')->toArray()))) selected @endif>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach

                            </select>
                            @if ($errors->has('tags'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('tags') }}
                                </div>
                            @endif
                        </div>

                        <div x-data="imageUploader()" x-init="init('{{ $post->thumbnail[0]->path ?? '' }}')">
                            <label for="file" class="mb-2 block text-lg font-medium text-gray-900 dark:text-gray-300">
                                ইমেজ আপলোড করুনঃ <span class="text-gray-600 font-light">(অপশনাল)</span>
                            </label>


                            <div class="mt-3 mb-4">
                                <input type="file" name="file" @change="handleFiles" accept="image/*" class="hidden"
                                    x-ref="file">
                                <button type="button" x-show="canAddMoreFiles()" @click="$refs.file.click()"
                                    class="block w-full border border-dashed border-gray-300 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                    ইমেজ আপলোড করুন
                                </button>
                            </div>

                            <template x-if="thumbnail">
                                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="relative">
                                        <img :src="thumbnail"
                                            class="w-full post-thumbnail h-52 md:h-72 object-cover rounded"
                                            alt="Image Preview">
                                        <button type="button" @click="removeThumbnail()"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center">×</button>
                                    </div>
                                </div>
                            </template>

                            <template x-if="images.length > 0">
                                <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <template x-for="(image, index) in images" :key="index">
                                        <div class="relative">
                                            <img :src="image.url" class="w-full h-52 md:h-72 object-cover rounded"
                                                alt="Image Preview">
                                            <button type="button" @click="removeImage(index)"
                                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center">×</button>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            @if ($errors->has('files'))
                                <div class="text-base font-medium text-red-600">
                                    {{ $errors->first('files') }}
                                </div>
                            @endif
                        </div>



                        {{-- {!! GoogleReCaptchaV3::renderField('update_story_id', 'update_story_action') !!} --}}
                        <button type="submit"
                            class="!mt-5 rounded-lg bg-theme-color py-2 px-5 text-center text-lg font-medium text-white outline-none hover:bg-theme-light dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit">
                            আপডেট করুন
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </main>

@endsection
