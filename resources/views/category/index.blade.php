<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Job Categories {{ __(request()->input('archived') == 'true' ? '(Archived)' : '(Active) ') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <!-- success messages -->
        <div class="overflow-x-auto p-6">
            <!-- success messages -->
            <div class="absolute inset-x-0 bottom-0 z-50">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
            </div>
        </div>


        <!-- Add New Category -->
        <div class="flex justify-end gap-4">
            <!-- Show "Active" button only when archived=true -->
            @if (request()->input('archived') == 'true')
                <a href="{{ route('job-categories.index', ['archived' => 'false']) }}"
                    class="inline-block mb-4 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600">
                    🗃️ Active
                </a>
                
            @else
                <!-- Show "View Archived Categories" only when archived=false -->
                <a href="{{ route('job-categories.index', ['archived' => 'true']) }}"
                    class="inline-block mb-4 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600">
                    🗃️ View Archived Categories
                </a>
                            <!-- Add Category button always visible -->
            <a href="{{ route('job-categories.create') }}"
                class="inline-block mb-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                ➕ Add Job Category
            </a>

            @endif


        </div>



        <!-- Job Categories Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-grey-600"> Category Name </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-grey-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class=" border-b">
                        <td class="px-6 py-3 text-grey-800"> {{ $category->name }} </td>
                        <td class="flex space px-6 py-3">
                            @if (request()->input('archived') == 'true')
                                <!-- restore button -->
                                <form action="{{ route('job-categories.restore', $category->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to restore this category?');">
                                    @method('PUT')
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-4">♻️ Restore</button>  
                                </form>  
                            @else
                            <div class="flex space-x-4">
                                <!-- edit buttons -->
                                <a href="{{ route('job-categories.edit', $category->id) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-4">✍️ Edit</a>
                                <!-- delete -->
                                <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">🗃️ Archive</button>
                                </form>
                            </div>
                            
                            @endif

                        </td>
                    </tr>
                @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                            </tr>
                        </tbody>
                    </table>

                @endforelse


    </div>
    <div class="mt-4">
        {{ $categories->links() }}
    </div>

</x-app-layout>