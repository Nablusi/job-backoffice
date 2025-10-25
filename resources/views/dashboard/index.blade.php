<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <!-- overview cards -->
        <div class="grid grid-cols-3 gap-6">
            <x-stat-card title="Active Users" value="{{ $analytics['activeUsers'] }}" subtitle="Last 30 days" />
            <x-stat-card title="Total Jobs" value="{{ $analytics['totalJobs'] }}" subtitle="All time" />
            <x-stat-card title="Total Applications" value="{{ $analytics['totalApplications'] }}" subtitle="All time" />
        </div>

        <!-- Most recent applications -->
        <x-card cardClass="mt-6 justify-start">
            <h2 class="text-lg font-medium text-gray-900">Most Applied Jobs</h2>
            <table class="w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-sm uppercase font-semibold text-gray-500 "> Job title </th>
                        <th class="px-6 py-3 text-left text-sm uppercase font-semibold text-gray-500"> Company </th>
                        <th class="px-6 py-3 text-left text-sm uppercase font-semibold text-gray-500"> Total
                            applications </th>
                    </tr>
                </thead>
                <tbody class=" divide-y divide-gray-200">
                    @foreach ($analytics['mostAppliedJobs'] as $job)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900"> {{ $job->title }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900"> {{ $job->company->name }} </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900"> {{ $job->totalCount }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </x-card>

        <!-- Conversion Rates -->

        <x-card cardClass="mt-6 justify-start">
            <h2 class="text-lg font-medium text-gray-900">Conversion Rates</h2>
            <table class="w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-sm uppercase font-semibold text-gray-500 "> Job title </th>
                        <th class="px-6 py-3 text-left text-sm uppercase font-semibold text-gray-500"> Views </th>
                        <th class="px-6 py-3 text-left text-sm uppercase font-semibold text-gray-500"> Applications
                        </th>
                        <th class="px-6 py-3 text-left text-sm uppercase font-semibold text-gray-500"> Conversion Rates
                        </th>
                    </tr>
                </thead>
                <tbody class=" divide-y divide-gray-200">
                    @foreach ($analytics['conversionRates'] as $conversionRate)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900"> {{ $conversionRate['title'] }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900"> {{ $conversionRate['viewCount'] }} </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900"> {{ $conversionRate['totalCount'] }} </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">  {{ $conversionRate['conversionRate'] }} % </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>
        </x-card>
    </div>
</x-app-layout>