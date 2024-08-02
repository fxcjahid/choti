@extends('public.account.index')
@section('subcontent')
    <div class="profile-edits">
        <div class="mb-5 border-b border-gray-100">
            <h1 class="mb-3 text-xl md:text-2xl text-slate-900">
                পাসওয়ার্ড পরিবর্তন করুন
            </h1>
            <div class="pb-3 text-base">
                আপনি যদি আপনার পাসওয়ার্ড ভুলে যান, তাহলে আপনি নিচের থেকে <b>'পাসওয়ার্ড ভুলে গেছেন'</b> - এই অপশনটি অনুসরণ
                করে একটি নতুন পাসওয়ার্ডের অনুরোধ করতে পারেন।
            </div>
        </div>
        <div class="my-5 mx-5">
            <div class="form-area md:max-w-[350px]">
                <form autocomplete="off" class="space-y-6">

                    <div class="form-group">
                        <label for="current_Password"
                            class="3 control-label mb-2 block col-md-3 text-lg font-medium text-gray-900 dark:text-gray-300 ">
                            {{ trans('attributes.current_Password') }} <span class="text-red-600 font-black">*</span>
                        </label>
                        <div class="col-md-9">
                            <input name="current_Password"
                                class="form-control block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                id="current_Password" value="" type="password" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_passowrd"
                            class="3 control-label mb-2 block col-md-3 text-lg font-medium text-gray-900 dark:text-gray-300 ">
                            {{ trans('attributes.new_passowrd') }} <span class="text-red-600 font-black">*</span>
                        </label>
                        <div class="col-md-9">
                            <input name="new_passowrd"
                                class="form-control block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                id="new_passowrd" value="" type="password" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password"
                            class="3 control-label mb-2 block col-md-3 text-lg font-medium text-gray-900 dark:text-gray-300 ">
                            {{ trans('attributes.confirm_password') }} <span class="text-red-600 font-black">*</span>
                        </label>
                        <div class="col-md-9">
                            <input name="confirm_password"
                                class="form-control block w-full rounded-md border-gray-200 py-2 px-4 text-lg outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                id="confirm_password" value="" type="password" autocomplete="off">
                        </div>
                    </div>

                    <div class="my-10">
                        <button type="submit"
                            class="rounded-lg bg-theme-color py-2 px-5 text-center text-base font-medium text-white outline-none hover:bg-theme-light dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit">
                            {{ trans('attributes.submit') }}
                        </button>
                    </div>

                    <div class="passowrd-forgot">
                        <a href="#" class="link">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
