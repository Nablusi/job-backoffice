<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- Category Creation Form -->
        <form method="POST" action="{{ route('job-categories.store') }}"
            class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            @csrf

            <x-toast-notification />
            <div class="flex flex-row flex-wrap gap-3 items-center justify-end">
                <a href="{{ route('job-categories.index') }}" class="text-grey-500 hover:text-grey-700 ">←
                    Cancel
                </a>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">Create
                        Category
                    </button>
                </div>

            </div>
        </form>

    </div>

</x-app-layout>