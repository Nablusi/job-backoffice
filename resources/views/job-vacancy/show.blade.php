<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobVacancy->title }} Details
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <!-- job vacancy Details -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Job Information</h3>
                <p><strong>Name:</strong> {{ $jobVacancy->company->name }}</p>
                <p><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                <p><strong>Type:</strong> {{ $jobVacancy->type }}</p>
                <p><strong>Salary:</strong> USD {{ number_format($jobVacancy->salary, decimals: 2) }}</p>
                <p><strong>Description:</strong> {{ $jobVacancy->description }}</p>
            </div>


            <!-- Edit and Archive Buttons -->
            <div class="flex justify-end space-x-4 mb-6 mt-6">
                <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'false']) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    ✍️ Edit
                </a>
                <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to archive this company?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600">
                        🗃️ Archive
                    </button>
                </form>

            </div>
            <!-- Table Navigation -->
            <div class="mb-6 flex space-x-4">
                <li class="list-none">
                    <a href="{{ route('job-vacancies.show', [$jobVacancy->id, 'tab' => 'applications']) }}"
                        class="px-4 py-2 text-grey-800 font-semibold   {{ request('tab') == 'applications' || request('tab') == '' ? 'border-b-2 border-blue-500 ' : '' }}">
                        Applications
                    </a>
                </li>
            </div>

            <!-- tab content -->
            <div>

                <!-- application content -->
                <div id="applications" class={{ request('tab') == 'applications' || request('tab') == '' ? 'block' : 'hidden' }}>
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
                            @forelse ($jobVacancy->jobApplication as $application)
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
        </div>
    </div>
</x-app-layout>