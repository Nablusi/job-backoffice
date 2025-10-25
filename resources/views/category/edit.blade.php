<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Category') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- Category Creation Form -->
        <form method="POST" action="{{ route('job-categories.update', $category->id) }}">
            class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Category Name:</label>
                <input type="text" name="name" id="name"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                    value="{{ old('name', $category->name) }}"
                    
                    
                    >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="flex flex-row flex-wrap gap-3 items-center justify-end">
                <a href="{{ route('job-categories.index') }}" class="text-grey-500 hover:text-grey-700 ">←
                    Cancel
                </a>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">Update
                        Category</button>
                </div>
            </div>
        </form>

    </div>



</x-app-layout>