<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Status {{ $application->user->name }} | Applied to {{ $application->jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- Job Application Form -->
        <form method="POST" action="{{ route('job-applications.update', $application->id) }}"
            class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            @method('PUT')
            @csrf
            <input type="hidden" name="redirectToList" value="{{ $redirectToList }}">
            <!-- company Details -->
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold"> Job Application Details </h3>
                <p class="text-sm mb-4"> Enter the Job Application details </p>
                <label class="block text-sm font-medium text-gray-700 ">
                    Applicant Name
                </label>
                <div class="mt-1 mb-2">
                    <p>
                        {{ $application->user->name}}
                    </p>
                </div>
                <label class="block text-sm font-medium text-gray-700">
                    Position
                </label>
                <div class="mt-1 mb-2">
                    <p>
                        {{ $application->jobVacancy->title}}
                    </p>
                </div>
                <label class="block text-sm font-medium text-gray-700">
                    Company Name
                </label>
                <div class="mt-1 mb-2">
                    <p>
                        {{ $application->jobVacancy->company->name}}
                    </p>
                </div>


                <label class="block text-sm font-medium text-gray-700">
                    AI Generated Score
                </label>
                <div class="mt-1 mb-2">
                    <p>
                        {{ $application->aiGeneratedScore }}
                    </p>
                </div>


                <label class="block text-sm font-medium text-gray-700">
                    AI Generated Feedback
                </label>
                <div class="mt-1 mb-2">
                    <p>
                        {{ $application->aiGeneratedFeedback }}
                    </p>
                </div>
                <!-- status drop down -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700"> Status </label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500">
                        <option value="pending" {{ old('status', $application->status) == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="reviewed" {{ old('status', $application->status) == 'reviewed' ? 'selected' : '' }}>
                            Reviewed
                        </option>
                        <option value="interviewed" {{ old('status', $application->status) == 'interviewed' ? 'selected' : '' }}>
                            Interviewed
                        </option>
                        <option value="accepted" {{ old('status', $application->status) == 'accepted' ? 'selected' : '' }}>
                            Accepted
                        </option>
                        <option value="rejected" {{ old('status', $application->status) == 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                    </select>
                    @error('companyId')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>


            <div class="flex flex-row flex-wrap gap-3 items-center justify-end">
                <a href="{{ route('job-applications.index') }}" class="text-grey-500 hover:text-grey-700 ">←
                    Cancel
                </a>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">Update
                        Status
                    </button>
                </div>

            </div>
        </form>

    </div>

</x-app-layout>