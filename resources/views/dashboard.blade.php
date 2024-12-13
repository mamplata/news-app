<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Dashboard') }}
            <a href="{{ route('news.create') }}"
                class="bg-green-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-green-700 transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>Create News Post
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Display Success or Error Message -->
            @if (session('status'))
                <div
                    class="mb-4 p-4 rounded-md text-white shadow-md
                @if (session('status') === 'success') bg-green-500 @else bg-red-500 @endif">
                    {{ session('message') }}
                </div>
            @endif

            <!-- News List -->
            <div class="mt-6 bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Latest News</h3>
                <ul>
                    @foreach ($news as $item)
                        <li
                            class="my-4 p-4 border-b last:border-b-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div>
                                <h4 class="font-bold text-xl text-blue-700">{{ $item->headline }}</h4>
                                <p class="text-sm text-gray-600">Published on:
                                    {{ \Carbon\Carbon::parse($item->date_published)->format('F j, Y') }} by
                                    {{ $item->user->name }}
                                </p>
                                <p class="mt-2 text-gray-800">{{ Str::limit($item->content, 150) }}</p>
                            </div>

                            <!-- Edit and Delete Buttons -->
                            <div class="mt-4 md:mt-0 flex space-x-2">
                                <a href="{{ route('news.edit', $item->id) }}"
                                    class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-md hover:bg-blue-600 transition duration-200 flex items-center">
                                    <i class="fas fa-edit mr-2"></i>Edit
                                </a>
                                <form action="{{ route('news.destroy', $item->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white py-2 px-4 rounded-md shadow-md hover:bg-red-600 transition duration-200 flex items-center">
                                        <i class="fas fa-trash mr-2"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
