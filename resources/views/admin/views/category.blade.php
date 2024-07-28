@extends('admin.app')
@section('title', 'Catagories')
@section('content')
    @include('admin.components.header')
    <!-- main content -->
    <main class="inline-flex w-full"
          areia-label="content">
        @include('admin.components.sidebar')
        <div role="catogories"
             class="w-full py-5 px-5">
            <create-category v-slot="vm">
                <div v-if="!vm.isEditCatogory">
                    <div
                         class="mb-4 text-2xl font-semibold capitalize text-gray-600 dark:text-gray-200">
                        Categories List - {{ $categoryCount }}
                    </div>
                    <div class="flex gap-7">
                        <div class="sticky top-[70px] h-[450px] w-2/5">
                            <div class="flex flex-col">
                                <div class="-m-1.5 overflow-x-auto">
                                    <div class="inline-block min-w-full p-1.5 align-middle">
                                        <div
                                             class="divide-y divide-gray-200 rounded-lg border dark:divide-gray-700 dark:border-gray-700">
                                            <form @submit.prevent="vm.store"
                                                  class="py-3 px-4"
                                                  autocomplete="off">
                                                <div
                                                     class="mb-2 text-base font-medium text-gray-600">
                                                    Add New Category
                                                </div>
                                                <div class="mb-1">
                                                    <label for="cat-name"
                                                           class="mb-2 block text-sm font-medium dark:text-white">
                                                        Name
                                                    </label>
                                                    <input type="text"
                                                           id="cat-name"
                                                           v-model="vm.form.name"
                                                           v-on:keyup="vm.updateSlug"
                                                           v-on:keydown="vm.updateSlug"
                                                           name="name"
                                                           autocomplete="off"
                                                           class="block w-full rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400" />
                                                </div>
                                                <div class="my-2">
                                                    <label for="cat-slug"
                                                           class="mb-2 block text-sm font-medium dark:text-white">
                                                        Slug
                                                    </label>
                                                    <input type="text"
                                                           id="cat-slug"
                                                           v-model="vm.form.slug"
                                                           v-on:change="vm.validationSlug"
                                                           name="slug"
                                                           autocomplete="off"
                                                           class="block w-full rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400" />
                                                </div>
                                                <div class="my-2">
                                                    <label for="parent-cat-dropdown"
                                                           class="mb-2 block text-sm font-medium dark:text-white">
                                                        Parent Category
                                                    </label>
                                                    <select name="parent_id"
                                                            class="block w-full rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                                            id="parent-cat-dropdown"
                                                            autocomplete="off"
                                                            disabled>
                                                        <option selected>None</option>
                                                    </select>
                                                </div>
                                                <div class="my-2">
                                                    <label for="cat-description"
                                                           class="mb-2 block text-base font-medium dark:text-white">
                                                        Description
                                                    </label>
                                                    <textarea id="cat-description"
                                                              v-model="vm.form.description"
                                                              name="description"
                                                              class="block w-full rounded-md border-gray-200 py-3 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                                              rows="3"></textarea>
                                                </div>
                                                <div class="mt-4 text-right">
                                                    <button type="submit"
                                                            v-bind:class="vm.isloading ?
                                                        'btn-loading disabled opacity-75' :
                                                        ''"
                                                            v-bind:disabled="vm.isloading"
                                                            class="inline-flex items-center justify-center gap-2 rounded-md border border-transparent bg-theme-color py-2 px-4 text-sm font-medium text-white transition-all">
                                                        Add New Category
                                                        <svg class="h-3.5 w-3.5"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             width="16"
                                                             height="16"
                                                             fill="currentColor"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                  d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717L5.07 1.243zM3.5 10.5a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="flex flex-col">
                                <div class="-m-1.5 overflow-x-auto">
                                    <div class="inline-block min-w-full p-1.5 align-middle">
                                        <div
                                             class="divide-y divide-gray-200 rounded-lg border dark:divide-gray-700 dark:border-gray-700">
                                            <div class="py-3 px-4">
                                                <div class="relative max-w-xs">
                                                    <label for="hs-table-search"
                                                           class="sr-only">Search</label>
                                                    <input type="text"
                                                           name="hs-table-search"
                                                           id="hs-table-search"
                                                           class="block w-full rounded-md border-gray-200 p-3 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                                           placeholder="Search for items" />
                                                    <div
                                                         class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                                        <svg class="h-3.5 w-3.5 text-gray-400"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             width="16"
                                                             height="16"
                                                             fill="currentColor"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                  d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
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
                                                                Post
                                                            </th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                                                Description
                                                            </th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-center text-xs font-medium uppercase text-gray-500">
                                                                Action
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody
                                                           class="divide-y divide-gray-200 dark:divide-gray-700">
                                                        <tr v-if="vm.isloading">
                                                            <td colspan="5">
                                                                <div
                                                                     class="py-5 px-5 text-center">
                                                                    <div role="status">
                                                                        <svg class="mr-2 inline h-8 w-8 animate-spin fill-blue-600 text-gray-200 dark:text-gray-600"
                                                                             viewBox="0 0 100 101"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                                                  fill="currentColor" />
                                                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                                                  fill="currentFill" />
                                                                        </svg>
                                                                        <span
                                                                              class="sr-only">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr v-for="item in vm.tables"
                                                            :class="{ 'bg-red-100': !item
                                                                    .is_active }">
                                                            <td v-text="item.name"
                                                                class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">

                                                            </td>
                                                            <td v-text="item.slug"
                                                                title="view categories post"
                                                                @click="vm.openPager(item.slug)"
                                                                class="whitespace-nowrap px-6 py-4 text-sm text-gray-800 hover:cursor-pointer hover:text-blue-500 hover:underline dark:text-gray-200">

                                                            </td>
                                                            <td v-text="item.post"
                                                                class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-800 dark:text-gray-200">
                                                            </td>
                                                            <td v-text="item.description"
                                                                :title="item.description"
                                                                class="ellipsis !table-cell max-w-0 overflow-hidden text-ellipsis whitespace-nowrap px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                            </td>
                                                            <td
                                                                class="flex items-center justify-center gap-3 whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                                                <button type="button"
                                                                        class="text-blue-500 hover:text-red-600"
                                                                        @click="vm.edit(item)">
                                                                    Edit
                                                                </button>
                                                                <button type="button"
                                                                        class="cursor-pointer text-blue-500 hover:text-red-600"
                                                                        @click="vm.destroy(item.id,item.name)">Delete</button>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div v-else>
                    <div
                         class="divide-y divide-gray-200 dark:divide-gray-700 dark:border-gray-700">
                        <form @submit.prevent="vm.update"
                              class="py-3 px-4"
                              autocomplete="off">
                            <div class="mb-4 text-xl font-semibold capitalize text-gray-600">
                                Edit Category: <span v-text="vm.form.name"></span>
                            </div>
                            <div class="mb-1">
                                <label for="cat-name"
                                       class="mb-2 block text-sm font-medium dark:text-white">
                                    Name
                                </label>
                                <input type="text"
                                       id="cat-name"
                                       v-model="vm.form.name"
                                       v-on:keyup="vm.updateSlug"
                                       v-on:keydown="vm.updateSlug"
                                       name="name"
                                       autocomplete="off"
                                       class="block w-auto min-w-[250px] rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400" />
                            </div>
                            <div class="my-2">
                                <label for="cat-slug"
                                       class="mb-2 block text-sm font-medium dark:text-white">
                                    Slug
                                </label>
                                <input type="text"
                                       id="cat-slug"
                                       v-model="vm.form.slug"
                                       v-on:change="vm.validationSlug"
                                       name="slug"
                                       autocomplete="off"
                                       class="block w-auto min-w-[250px] rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400" />
                            </div>
                            <div class="my-2">
                                <label for="parent-cat-dropdown"
                                       class="mb-2 block text-sm font-medium dark:text-white">
                                    Parent Category
                                </label>
                                <select name="parent_id"
                                        class="block w-auto min-w-[250px] rounded-md border-gray-200 py-2 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                        id="parent-cat-dropdown"
                                        autocomplete="off"
                                        disabled>
                                    <option selected>None</option>
                                </select>
                            </div>
                            <div class="my-2">
                                <label for="cat-description"
                                       class="mb-2 block text-base font-medium dark:text-white">
                                    Description
                                </label>
                                <textarea id="cat-description"
                                          v-model="vm.form.description"
                                          name="description"
                                          class="block w-auto min-w-[250px] resize rounded-md border-gray-200 py-3 px-4 text-base outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                                          rows="3"></textarea>
                            </div>

                            <div class="mt-4 flex">
                                <input type="checkbox"
                                       class="pointer-events-none mt-0.5 shrink-0 rounded border-gray-200 text-blue-600 outline-none dark:border-gray-700 dark:bg-gray-800 dark:checked:border-blue-500 dark:checked:bg-blue-500"
                                       id="hs-default-checkbox"
                                       v-model="vm.form.is_active"
                                       name="is_active">
                                <label for="hs-default-checkbox"
                                       class="ml-3 text-base font-medium dark:text-gray-400">
                                    Enable the category
                                </label>
                            </div>

                            <div class="mt-8 text-left">
                                <button type="submit"
                                        v-bind:class="vm.isloading ?
                                                        'btn-loading disabled opacity-75' :
                                                        ''"
                                        v-bind:disabled="vm.isloading"
                                        class="inline-flex items-center justify-center gap-2 rounded-md border border-transparent bg-theme-color py-2 px-4 text-sm font-medium text-white transition-all">
                                    Update Category
                                    <svg class="h-3.5 w-3.5"
                                         xmlns="http://www.w3.org/2000/svg"
                                         width="16"
                                         height="16"
                                         fill="currentColor"
                                         viewBox="0 0 16 16">
                                        <path
                                              d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717L5.07 1.243zM3.5 10.5a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3z" />
                                    </svg>
                                </button>
                                <button type="button"
                                        @click="vm.editClose()"
                                        class="ml-5 inline-flex items-center justify-center gap-2 rounded-md border border-transparent bg-slate-600 py-2 px-4 text-sm font-medium text-white transition-all">
                                    Cencel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </create-category>
        </div>
    </main>
@endsection
