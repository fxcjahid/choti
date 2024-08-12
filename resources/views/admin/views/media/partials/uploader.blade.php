<create-uploader v-slot="vm">
    <div class="flex w-full items-center justify-center" v-bind="vm.getRootProps()">
        <div for="dropzone-file"
            :class="vm.isDragActive ? ' bg-orange-50 border-orange-200 ' :
                'bg-gray-50 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-600 border-gray-300  hover:bg-gray-100 dark:border-gray-600'"
            class="dark:hover:bg-bray-800 flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed">
            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                <div>
                    <svg aria-hidden="true" class="mx-auto mb-3 h-10 w-10 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                    <p v-if="vm.isDragActive" class="mb-2 text-base font-semibold text-indigo-600 dark:text-gray-400">
                        Drop the files here ...
                    </p>
                    <p v-else class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold">
                            Click to upload
                        </span>
                        or drag and drop
                    </p>
                    <p class="text-center text-xs text-gray-500 dark:text-gray-400">
                        JPEG, JPG, PNG or WEBP
                        (MAX. <span>{{ env('Image_Max_Width') }}</span> x
                        <span>{{ env('Image_Max_Height') }}</span> px)
                    </p>
                    <p class="text-center text-xs text-gray-500 dark:text-gray-400">
                        Maximum upload size
                        {{ (int) ini_get('upload_max_filesize') / 8 }} MB
                    </p>
                </div>
                <div class="hidden h-2.5 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                    <div class="h-2.5 rounded-full bg-blue-600" style="width: 45%"></div>
                </div>
            </div>
        </div>
        <input class="hidden" v-bind="vm.getInputProps()" />
    </div>
</create-uploader>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg md:my-20">
    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all-search" type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                    </div>
                </th>
                <th scope="col" class="py-3 px-6">
                    Thumbnail
                </th>
                <th scope="col" class="py-3 px-6">
                    File Name
                </th>
                <th scope="col" class="py-3 px-6">
                    Created
                </th>
                <th scope="col" class="py-3 px-6">
                    User
                </th>
                <th scope="col" class="py-3 px-6 text-center">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($table as $row)
                <tr
                    class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input id="checkbox-table-search-2" type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                            <label for="checkbox-table-search-2" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <th scope="row" class="whitespace-nowrap py-4 px-6 font-medium text-gray-900 dark:text-white">
                        <div class="m-1 h-16 w-16 rounded-md border">
                            <img class="h-16 w-16 rounded-md p-1" src="{{ $row->small }}" alt="thumbnail">
                        </div>
                    </th>
                    <td class="py-4 px-6">
                        <div class="w-56 overflow-hidden text-ellipsis whitespace-nowrap">
                            {{ $row->filename }}
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        {{ $row->created_at->diffForHumans() }}
                    </td>
                    <td class="py-4 px-6">
                        {{ $row->user->name ?? 'unknown' }}
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-center gap-2">
                            <a href="#"
                                class="font-medium text-blue-600 hover:underline dark:text-blue-500">Edit</a>
                            <a href="#"
                                class="font-medium text-red-600 hover:underline dark:text-red-500">Remove</a>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-10 mb-4 px-3">
        {{ $table->links('admin.components.pagination') }}
    </div>
</div>
