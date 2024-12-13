<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <i class="fas fa-edit mr-2 text-blue-500"></i>
            {{ __('Edit News Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('news.update', $news->id) }}">
                @csrf
                @method('PUT')

                <!-- Headline -->
                <div class="mb-4">
                    <label for="headline" class="block text-sm font-medium text-gray-700">Headline</label>
                    <input type="text" id="headline" name="headline"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ old('headline', $news->headline) }}" placeholder="Edit headline here" required>
                    @error('headline')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea id="content" name="content" rows="5"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="Edit the news content here..." required>{{ old('content', $news->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Author -->
                <div class="mb-4">
                    <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                    <input type="text" id="author" name="author"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ old('author', $news->author) }}" required>
                    @error('author')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Published -->
                <div class="mb-4">
                    <label for="date_published" class="block text-sm font-medium text-gray-700">Date Published</label>
                    <input type="date" id="date_published" name="date_published"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        value="{{ old('date_published', $news->date_published) }}" required>
                    @error('date_published')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="mt-6 flex justify-end space-x-2">
                    <a href="{{ route('dashboard') }}"
                        class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-md hover:bg-gray-600 transition duration-200 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-md hover:bg-blue-600 transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>Update News
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
