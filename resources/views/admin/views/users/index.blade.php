@extends('admin.app')
@section('title', 'Tags')
@section('content')

    @include('admin.components.header')
    <!-- main content -->
    <main class="inline-flex w-full" areia-label="content">
        @include('admin.components.sidebar')
        <div role="catogories" class="w-full py-5 px-5">
            <div>
                <div class="mb-4 text-2xl font-semibold capitalize text-gray-600 dark:text-gray-200">
                    Users List - {{ $totalUser }}
                </div>
                <div class="flex gap-7">
                    <div class="w-full transition-all">
                        <div class="flex flex-col">
                            <div class="-m-1.5 overflow-x-auto">
                                <div class="inline-block min-w-full p-1.5 align-middle">
                                    <div
                                        class="divide-y divide-gray-200 rounded-lg border dark:divide-gray-700 dark:border-gray-700">
                                        <div class="py-3 px-4">
                                            <div class="relative max-w-xs">
                                                <label for="hs-table-search" class="sr-only">Search</label>
                                                <input type="text" name="hs-table-search" id="hs-table-search"
                                                    class="block w-full rounded-md border-gray-200 p-3 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                                    placeholder="Search for items" />
                                                <div
                                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                                    <svg class="h-3.5 w-3.5 text-gray-400"
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" viewBox="0 0 16 16">
                                                        <path
                                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="overflow-hidden">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                <thead class="bg-gray-50 dark:bg-gray-700">
                                                    <tr>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                                            Name
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                                            Email
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-center text-xs font-medium uppercase text-gray-500">
                                                            Post
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                                            Last Login
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-center text-xs font-medium uppercase text-gray-500">
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                    @forelse ($users as $user)
                                                        <tr>
                                                            <td
                                                                class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">
                                                                {{ $user->name }}
                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap px-6 py-4 text-sm text-gray-800 hover:cursor-pointer hover:text-blue-500 hover:underline dark:text-gray-200">
                                                                {{ $user->email }}
                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-800 dark:text-gray-200">
                                                                {{ $user->post }}
                                                            </td>
                                                            <td
                                                                class="ellipsis !table-cell max-w-0 overflow-hidden text-ellipsis whitespace-nowrap px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                                last login
                                                            </td>
                                                            <td
                                                                class="flex items-center justify-center gap-3 whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                                                <button type="button"
                                                                    class="text-blue-500 hover:text-red-600">
                                                                    Edit
                                                                </button>
                                                                <button type="button"
                                                                    class="cursor-pointer text-blue-500 hover:text-red-600">Delete</button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td
                                                                class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">
                                                                No data found
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-10 mb-4">
                                        {{ $users->links('admin.components.pagination') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
