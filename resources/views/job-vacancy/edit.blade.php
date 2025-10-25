<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Job Vacancy {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- company Creation Form -->
        <form method="POST" action="{{ route('job-vacancies.update', $jobVacancy->id) }}"
            class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            @method('PUT')
            @csrf
            <input type="hidden" name="redirectToList" value="{{ $redirectToList }}">
            <!-- company Details -->
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold"> Job Vacancy Details </h3>
                <p class="text-sm mb-4"> Enter the Job Vacancy details </p>
                <x-input-field label="Job Vacancy title" name="title" value="{{ old('title', $jobVacancy->title) }}" />
                <x-input-field label="Location" name="location" value="{{ old('location', $jobVacancy->location) }}" />

                <div class="mb-4">
                    <label for="industry" class="block text-sm font-medium text-gray-700"> Type </label>
                    <select name="type" id="type"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500">
                        <option value="Full-time" {{ old('type', 'Full-time') ? 'selected' : '' }}> Full-Time </option>
                        <option value="Part-time" {{ old('type', 'Part-time') ? 'selected' : '' }}> Part-Time </option>
                        <option value="Contract" {{ old('type', 'Contract') ? 'selected' : '' }}> Contract </option>
                        <option value="Remote" {{ old('type', 'Remote') ? 'selected' : '' }}> Remote </option>
                        <option value="Internship" {{ old('type', 'Internship') ? 'selected' : '' }}> Internship
                        </option>
                        <option value="Hybrid" {{ old('type', 'Hybrid') ? 'selected' : '' }}> Hybrid </option>
                    </select>
                </div>
                <x-input-field label="Expected Salary (USD)" name="salary" type="number"
                    value="{{ old('salary', $jobVacancy->salary) }}" />
            </div>

            <!-- company drop down -->
            <div class="mb-4">
                <label for="company_id" class="block text-sm font-medium text-gray-700"> Company </label>
                <select name="companyId" id="company_id"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500">
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company', $company->id) ? 'selected' : '' }}>
                            {{ $company->name }} </option>
                    @endforeach
                </select>
                @error('companyId')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>



            <!-- job category drop down -->

            <div class="mb-4">
                <label for="job_category_id" class="block text-sm font-medium text-gray-700"> Job Category </label>
                <select name="categoryId" id="job_category_id"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500">
                    @foreach ($jobCategories as $jobCategory)
                        <option value="{{ $jobCategory->id }}" {{ old('categoryId', $jobVacancy->categoryId) == $jobCategory->id ? 'selected' : '' }}>
                            {{ $jobCategory->name }}
                        </option>
                    @endforeach
                </select>
                @error('categoryId')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- job description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700"> Job Description </label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500">
                    {{ old('description', $jobVacancy->description) }}
                </textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-row flex-wrap gap-3 items-center justify-end">
                <a href="{{ route('job-vacancies.index') }}" class="text-grey-500 hover:text-grey-700 ">←
                    Cancel
                </a>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">Update
                        Job vacancy
                    </button>
                </div>

            </div>
        </form>

    </div>

</x-app-layout>