<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job applications {{ __(request()->input('archived') == 'true' ? '(Archived)' : '(Active) ') }}
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


        <!-- Add New job application -->
        <div class="flex justify-end gap-4">
            <!-- Show "Active" button only when archived=true -->
            @if (request()->input('archived') == 'true')
                <a href="{{ route('job-applications.index', ['archived' => 'false']) }}"
                    class="inline-block mb-4 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600">
                    🗃️ Active
                </a>

            @else
                <!-- Show "View Archived job-applications" only when archived=false -->
                <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                    class="inline-block mb-4 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600">
                    🗃️ View Archived job vacancies
                </a>
            @endif


        </div>



        <!--  job-applications Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-grey-600"> Applicant Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-grey-600"> Position </th>
                    @if (auth()->user()->role == 'admin')
                    <th class="px-6 py-3 text-left text-sm font-semibold text-grey-600"> Company </th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-grey-600"> Status </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-grey-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $application)
                                    <tr class=" border-b">
                                        <td class="px-6 py-3 text-grey-800"> <a class="text-blue-500 underline" href={{ route('job-applications.show', $application->id)}}> {{ $application->user->name }} </a>
                                        </td>
                                        <td class="px-6 py-3 text-grey-800"> {{ $application->jobVacancy->title }} </td>
                                        @if (auth()->user()->role == 'admin')
                                        <td class="px-6 py-3 text-grey-800"> {{ $application->jobVacancy->company->name }} </td>
                                    
                                        @endif
                                        <td class="px-6 py-3 text-grey-800 
                        {{
                            $application->status == 'accepted' ? 'text-green-600' :
                            ($application->status == 'rejected' ? 'text-red-600' :
                                ($application->status == 'pending' ? 'text-yellow-600' :
                                    ($application->status == 'interviewed' ? 'text-blue-600' : 'text-red-600')))
                        }}
                    ">
                                            {{ $application->status }}
                                        </td>

                                        <td class="flex space px-6 py-3">
                                            @if (request()->input('archived') == 'true')
                                                <!-- restore button -->
                                                <form action="{{ route('job-applications.restore', $application->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to restore this job application?');">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-4">♻️ Restore</button>
                                                </form>
                                            @else
                                                <div class="flex space-x-4">
                                                    <!-- edit buttons -->
                                                    <a href="{{ route('job-applications.edit', ['job_application' => $application->id, 'redirectToList' => 'false']) }}"
                                                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                                        ✍️ Edit
                                                    </a>
                                                    <!-- delete -->
                                                    <form action="{{ route('job-applications.destroy', $application->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this job application?');">
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
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">No job-applications found.</td>
                            </tr>
                        </tbody>
                    </table>

                @endforelse


    </div>
    <div class="mt-4">
        {{ $applications->links() }}
    </div>

</x-app-layout>