@extends('admin.app')
@section('title', 'Page')

@section('content')

    @include('admin.components.header')

    {{-- main content --}}
    <main class="inline-flex w-full"
          areia-label="content">
        @include('admin.components.sidebar')
        <div class="w-full py-5 px-5">

            @include('admin.components.errors')

            <!-- page content -->
            <section aria-label="page">
                <page-index v-slot="vm">
                    <div class="mt-0">

                        <div class="flex justify-between">
                            <div
                                 class="mb-4 text-2xl font-semibold capitalize text-gray-600 dark:text-gray-200">
                                Page List
                            </div>
                            <div class="text-right">
                                <button type="submit"
                                        v-on:click="vm.create"
                                        :class="vm.isloading ? 'btn-loading disabled' : ''"
                                        :disabled="vm.isloading"
                                        class="inline-flex items-center justify-center gap-2 rounded-md border border-transparent bg-theme-color py-2 px-4 text-sm font-medium text-white transition-all">
                                    Add New Page
                                    <svg class="h-3.5 w-3.5"
                                         xmlns="http://www.w3.org/2000/svg"
                                         width="16"
                                         height="16"
                                         fill="currentColor"
                                         viewBox="0 0 16 16">
                                        <path
                                              d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- filter option --}}

                        <div class="w-full">
                            <div class="inline-flex w-full justify-between">
                                @include('admin.views.page.filters.switch-page-type')
                                @include('admin.views.page.filters.switch-page-filter')
                            </div>
                        </div>

                        <!-- page list -->
                        <div class="w-full">
                            <div class="flex flex-col">
                                <div class="-m-1.5 overflow-x-auto">
                                    <div class="inline-block min-w-full p-1.5 align-middle">
                                        <div
                                             class="divide-y divide-gray-200 rounded-lg border dark:divide-gray-700 dark:border-gray-700">
                                            <div class="py-3 px-4">
                                                {{-- search item --}}
                                                <div class="relative ml-auto max-w-xs">
                                                    <label for="hs-table-search"
                                                           class="sr-only">
                                                        Search
                                                    </label>
                                                    <input type="text"
                                                           name="hs-table-search"
                                                           id="hs-table-search"
                                                           class="block w-full rounded-md border-gray-200 p-3 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                                           placeholder="Search for items">
                                                    <div
                                                         class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                                        <svg class="h-3.5 w-3.5 text-gray-400"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             width="16"
                                                             height="16"
                                                             fill="currentColor"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                  d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="overflow-hidden">
                                                <table
                                                       class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                    <thead
                                                           class="bg-gray-50 dark:bg-gray-700">
                                                        <tr>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                                                Name
                                                            </th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                                                Slug
                                                            </th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-center text-xs font-medium uppercase text-gray-500">
                                                                Status
                                                            </th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-center text-xs font-medium uppercase text-gray-500">
                                                                Create at
                                                            </th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                                                Author
                                                            </th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-center text-xs font-medium uppercase text-gray-500">
                                                                Action
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody
                                                           class="divide-y divide-gray-200 dark:divide-gray-700">
                                                        @foreach ($page as $item)
                                                            <tr @class([
                                                                'bg-red-100' => $item->status != 'publish' ? true : false,
                                                            ])>
                                                                <td
                                                                    class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">
                                                                    {{ $item->name }}
                                                                </td>
                                                                <td title="view categories post"
                                                                    class="whitespace-nowrap px-6 py-4 text-sm text-gray-800 hover:cursor-pointer hover:text-blue-500 hover:underline dark:text-gray-200">
                                                                    {{ $item->slug }}
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-800 dark:text-gray-200">
                                                                    {{ $item->status }}
                                                                </td>
                                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-800 dark:text-gray-200"
                                                                    title="{{ $item->created_at->diffForHumans() }}">
                                                                    {{ $item->created_at->format('h:i A,  d-M-Y') }}
                                                                </td>
                                                                <td
                                                                    class="ellipsis !table-cell max-w-0 overflow-hidden text-ellipsis whitespace-nowrap px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                                    {{ $item->user->username }}
                                                                </td>
                                                                <td
                                                                    class="flex items-center justify-center gap-3 whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                                                    <button type="button"
                                                                            class="text-blue-500 hover:text-red-600">
                                                                        Edit
                                                                    </button>
                                                                    <button type="button"
                                                                            class="cursor-pointer text-red-500 hover:text-red-600"
                                                                            v-on:click="vm.moveTrash({{ $item->id }},'{{ $item->name }}')">
                                                                        Move Trash
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-10 mb-4">
                                {{ $page->links('admin.components.pagination') }}
                            </div>
                        </div>

                    </div>
                </page-index>
            </section>
        </div>
    </main>
@endsection
