@extends('public.account.index')
@section('subcontent')
    <div class="profile-edits">
        <div class="mb-5 border-b border-gray-100">
            <h1 class="mb-3 text-xl md:text-2xl text-slate-900">
                {{ trans('account.profile.title') }}
            </h1>
            <div class="page-description"></div>
        </div>
        <div class="my-5 mx-5">
            <div class="form-area md:max-w-[350px]">
                <form autocomplete="off" class="space-y-6">

                    <div class="form-group">
                        <label for="name"
                            class="3 control-label mb-2 block col-md-3 text-lg font-medium text-gray-900 dark:text-gray-300 ">
                            {{ trans('attributes.name') }} <span class="text-red-600 font-black">*</span>
                        </label>
                        <div class="col-md-9">
                            <input name="name"
                                class="form-control block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                id="name" value="{{ old('name', auth()->user()->name) }}" type="text"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username"
                            class="3 control-label mb-2 block col-md-3 text-lg font-medium text-gray-900 dark:text-gray-300 ">
                            {{ trans('attributes.username') }}
                        </label>
                        <div class="col-md-9">
                            <input name="username"
                                class="form-control block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                id="username" value="{{ old('name', auth()->user()->username) }}" type="text"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bio"
                            class="3 control-label mb-2 block col-md-3 text-lg font-medium text-gray-900 dark:text-gray-300 ">
                            {{ trans('attributes.bio') }}
                        </label>
                        <div class="col-md-9">
                            <textarea name="bio"
                                class="form-control block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                id="bio" autocomplete="off"></textarea>
                        </div>
                    </div>

                    <div class="my-10">
                        <button type="submit"
                            class="rounded-lg bg-theme-color py-2 px-5 text-center text-base font-medium text-white outline-none hover:bg-theme-light dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit">
                            সাবমিট করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
