@extends('admin.app')


@section('content')
    <section class="bg-gray-50 dark:bg-gray-900">
        <div
             class="mx-auto flex flex-col items-center justify-center px-6 py-8 md:h-screen lg:py-0">
            <a href="{{ route('home') }}"
               target="_blank"
               class="mb-6 flex items-center text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="mr-2 h-8 w-8"
                     src="{{ asset('assets/admin/img/icon.png') }}"
                     alt="logo">
                Blanee.com
            </a>
            <div
                 class="w-full rounded-lg bg-white shadow dark:border dark:border-gray-700 dark:bg-gray-800 sm:max-w-md md:mt-0 xl:p-0">
                <div class="space-y-4 p-6 sm:p-8 md:space-y-6">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-2xl">
                        Sign in to admin panel
                    </h1>
                    <form method="POST"
                          class="space-y-4 md:space-y-6"
                          action="{{ route('admin.login.post') }}">
                        @csrf
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                @error('warning')
                                    <div class="mb-4 rounded-lg bg-indigo-100 p-4 text-sm font-medium text-red-600"
                                         role="warning">
                                        <div> {{ $error }} </div>
                                    </div>
                                @enderror

                                @error('error')
                                    <div class="mb-4 flex rounded-lg bg-red-100 p-4 text-sm text-red-700"
                                         role="alert">
                                        <svg class="mr-3 inline h-5 w-5"
                                             fill="currentColor"
                                             viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                        <div> {{ $error }} </div>
                                    </div>
                                @enderror
                            @endforeach
                        @endif

                        <div>
                            <label for="email"
                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Email
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="@error('email') is-invalid @enderror block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-gray-900 outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                   placeholder="Email Address"
                                   value="{{ old('email') }}"
                                   required=""
                                   autofocus>
                            @error('email')
                                <span class="invalid-feedback"
                                      role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label for="password"
                                   class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Password
                            </label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   placeholder="••••••••"
                                   class="@error('password') is-invalid @enderror block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-gray-900 outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                   required=""
                                   autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback"
                                      role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="remember"
                                           aria-describedby="remember"
                                           type="checkbox"
                                           class="focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 h-4 w-4 rounded border border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember"
                                           class="select-none text-gray-500 dark:text-gray-300">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <a href="#"
                               class="text-primary-600 dark:text-primary-500 text-sm font-medium hover:underline">
                                Forgot password?
                            </a>
                        </div>

                        <button type="submit"
                                class="w-full rounded-lg bg-red-800 px-5 py-2.5 text-center text-sm font-medium text-white outline-none hover:bg-red-900">
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
