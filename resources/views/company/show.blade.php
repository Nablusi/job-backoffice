<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }} Details
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <!-- Company Details -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Company Information</h3>
                <p><strong>Address:</strong> {{ $company->address }}</p>
                <p><strong>Industry:</strong> {{ $company->industry }}</p>
                <p><strong>Website:</strong> <a href="{{ $company->website }}" class="text-blue-500 underline"
                        target="_blank">{{ $company->website }}</a></p>
            </div>


            <!-- Edit and Archive Buttons -->
            <div class="flex justify-end space-x-4 mb-6 mt-6">
                <a href="{{ route(auth()->user()->role == 'admin' ? 'companies.edit' : 'my-company.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    ✍️ Edit
                </a>
                @if(auth()->user()->role == 'admin')
                <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to archive this company?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600">
                        🗃️ Archive
                    </button>
                </form>
                @endif

            </div>
            @if (auth()->user()->role == 'admin')
            <!-- Table Navigation -->
            <div class="mb-6 flex space-x-4">
                <li class="list-none">
                    <a href="{{ route('companies.show', [$company->id, 'tab' => 'jobs']) }}"
                        class="px-4 py-2 text-grey-800 font-semibold  {{ request('tab') == 'jobs' || request('tab') == '' ? 'border-b-2 border-blue-500 ' : '' }}">
                        Jobs
                    </a>
                </li>
                <li class="list-none">
                    <a href="{{ route('companies.show', [$company->id, 'tab' => 'applications']) }}"
                        class="px-4 py-2 text-grey-800 font-semibold   {{ request('tab') == 'applications' ? 'border-b-2 border-blue-500 ' : '' }}">
                        Applications
                    </a>
                </li>
            </div>

     
            


    
            <!-- tab content -->
            <div>
                <!-- job content -->
                <div id="jobs" class={{ request('tab') == 'jobs' || request('tab') == '' ? 'block' : 'hidden' }}>
                    <h3 class="text-lg font-bold"> Job Content </h3>
                    <table class="w-full mt-6">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-start bg-green-100 rounded-tl-lg">Title</th>
                                <th class="py-2 px-4 text-start bg-green-100 ">Type</th>
                                <th class="py-2 px-4 text-start bg-green-100 ">Location</th>
                                <th class="py-2 px-4 text-start bg-green-100 rounded-tr-lg">Actions
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($company->jobVacancies as $job)
                                <tr class="border-b">
                                    <td class="py-2 px-4">{{ $job->title }}</td>
                                    <td class="py-2 px-4">{{ $job->type }}</td>
                                    <td class="py-2 px-4">{{ $job->location }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('job-vacancies.show', $job->id) }}"
                                            class="text-blue-500 underline mr-4">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 px-4 text-center text-gray-500">No jobs found for this
                                        company.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- application content -->
                <div id="applications" class={{ request('tab') == 'applications' ? 'block' : 'hidden' }}>
                    <h3 class="text-lg font-bold"> Applications Content </h3>
                    <table class="w-full mt-6">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-start bg-green-100 rounded-tl-lg">Applicant Name</th>
                                <th class="py-2 px-4 text-start bg-green-100 ">Job Title</th>
                                <th class="py-2 px-4 text-start bg-green-100 ">Status</th>
                                <th class="py-2 px-4 text-start bg-green-100 rounded-tr-lg">Actions
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($company->jobApplications as $application)
                                <tr class="border-b">
                                    <td class="py-2 px-4">{{ $application->user->name }}</td>
                                    <td class="py-2 px-4">{{ $application->jobVacancy->title ?? 'N/A' }}</td>
                                    <td class="py-2 px-4">{{ $application->status }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('job-applications.show', $application->id) }}"
                                            class="text-blue-500 underline mr-4">View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 px-4 text-center text-gray-500">No applications found
                                        for this company.</td>
                                </tr>
                            @endforelse
                        </tbody>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>