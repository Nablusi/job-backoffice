<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $application->user->name }} | Applied to {{ $application->jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <!-- job vacancy Details -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Application Details</h3>

                <p><strong>Applicant Name:</strong> {{ $application->user->name }}</p>
                <p><strong>Job Vacancy:</strong> {{ $application->jobVacancy->title }}</p>
                <p><strong>Company:</strong> {{ $application->jobVacancy->company->name }}</p>
                <p><strong>Status:</strong> {{ $application->status }}</p>
                <p><strong>Resume:</strong>
                    <a href="{{ $application->resume->fileUri }}" class="text-blue-500 underline" target="_blank">View
                        Resume</a>
                </p>
            </div>


            <!-- Edit and Archive Buttons -->
            <div class="flex justify-end space-x-4 mb-6 mt-6">
                <a href="{{ route('job-applications.edit', ['job_application' => $application->id, 'redirectToList' => 'true']) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    ✍️ Edit
                </a>
                <form action="{{ route('job-applications.destroy', $application->id) }}" method="POST"
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
            <div class="flex flex-row  gap-3 items-center">

                <div class="mb-6 flex space-x-4">
                    <li class="list-none">
                        <a href="{{ route('job-applications.show', [$application->id, 'tab' => 'resume']) }}"
                            class="px-4 py-2 text-grey-800 font-semibold   {{ request('tab') == 'resume' || request('tab') == '' ? 'border-b-2 border-blue-500 ' : '' }}">
                            View Resume
                        </a>
                    </li>
                </div>

                <div class="mb-6 flex space-x-4">
                    <li class="list-none">
                        <a href="{{ route('job-applications.show', [$application->id, 'tab' => 'AIFeedback']) }}"
                            class="px-4 py-2 text-grey-800 font-semibold   {{ request('tab') == 'AIFeedback' ? 'border-b-2 border-blue-500 ' : '' }}">
                            AI FeedBack
                        </a>
                    </li>
                </div>
            </div>

            <!-- tab content -->
            <div>
                <!-- resume content -->
                <div id="resume" class={{ request('tab') == 'resume' || request('tab') == '' ? 'block' : 'hidden' }}>
                    <table>
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Summary</th>
                                <th class="py-2 px-4 text-left bg-gray-100 ">Skills</th>
                                <th class="py-2 px-4 text-left bg-gray-100 ">Experience</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Education</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $application->resume->summary }}</td>
                                <td class="py-2 px-4 border-b">{{ $application->resume->skills }}</td>
                                <td class="py-2 px-4 border-b">{{ $application->resume->experience }}</td>
                                <td class="py-2 px-4 border-b">{{ $application->resume->education }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <!-- application content -->
                <div id="applications" class={{ request('tab') == 'AIFeedback' ? 'block' : 'hidden' }}>
                    <table>
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">AI Score</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">AI Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $application->aiGeneratedScore }}</td>
                                <td class="py-2 px-4 border-b">{{ $application->aiGeneratedFeedback }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>