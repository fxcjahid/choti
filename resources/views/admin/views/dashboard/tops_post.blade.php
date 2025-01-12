<div
    class="w-7/12 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <!-- Card header -->
    <div class="items-center justify-between lg:flex">
        <div class="mb-4 lg:mb-0">
            <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Tops Post</h3>
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">
                This is a list of latest most views post
            </span>
        </div>

    </div>
    <!-- Table -->
    <div class="flex flex-col mt-6">
        <div class="overflow-x-auto rounded-lg">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left  uppercase dark:text-white">
                                    Name
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs text-center font-medium tracking-wider uppercase dark:text-white">
                                    views
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @foreach ($topPosts as $post)
                                <tr class="px-2 py-4 border-b last:border-b-0 hover:bg-gray-50">
                                    <td
                                        class="py-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ $post->url }}" target="_blank"
                                            class="text-blue-900 hover:cursor-pointer hover:text-blue-500 ">{{ $post->name }}</a>
                                    </td>
                                    <td
                                        class="py-4 text-base font-semibold text-center text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $post->views }}
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
