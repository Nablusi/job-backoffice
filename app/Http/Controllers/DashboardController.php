<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\JobApplication;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()->role == 'admin') {
            $analytics = $this->adminDashboard();
            return view('dashboard.index', compact('analytics'));
        } else{
            $analytics = $this->companyOwnerDashboard();
            return view('dashboard.index', compact('analytics'));
        }
    }

    private function adminDashboard()
    {
        // last 30 days active users (job-seekers only)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')->count();

        // Total Jobs (not deleted)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        // Total applications (not deleted)
        $totalApplications = JobApplication::whereNull('deleted_at')->count();

        // most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplication as totalCount')->get()->sortByDesc('TotalCount')->take(5);

        // conversion rates
        $conversionRates = JobVacancy::withCount('jobApplication as totalCount')
            ->having('totalCount', '>', 0)
            ->orderByDesc('totalCount')
            ->take(5)
            ->get()
            ->map(function ($job) {
                $conversionRate = $job->viewCount > 0
                    ? ($job->totalCount / $job->viewCount) * 100
                    : 0;
                return [
                    'title' => $job->title,
                    'viewCount' => $job->viewCount,
                    'totalCount' => $job->totalCount,
                    'conversionRate' => number_format($conversionRate, 2),
                ];
            });

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs'=> $mostAppliedJobs,
            'conversionRates' => $conversionRates
        ];


        return $analytics;
    }

    private function companyOwnerDashboard()
    {
        // filter active users by applied to the company
$activeUsers = User::where('role', 'job-seeker')
    ->where('last_login_at', '>=', now()->subDays(30))
    ->whereHas('jobApplications.jobVacancy.company', function ($query) {
        $query->where('ownerId', auth()->user()->id);
    })
    ->distinct('id')
    ->count('id');

        // Total Jobs (not deleted)
        $totalJobs = JobVacancy::whereHas('company', function ($query) {
            $query->where('ownerId', auth()->user()->id);
        })->whereNull('deleted_at')->count();

        // Total applications (not deleted)
        $totalApplications = JobApplication::whereHas('jobVacancy', function ($query) {
            $query->whereHas('company', function ($query) {
                $query->where('ownerId', auth()->user()->id);
            });
        })->whereNull('deleted_at')->count();

        // most applied jobs
        $mostAppliedJobs = JobVacancy::whereHas('company', function ($query) {
            $query->where('ownerId', auth()->user()->id);
        })->withCount('jobApplication as totalCount')->get()->sortByDesc('TotalCount')->take(5);

        // conversion rates
        $conversionRates = JobVacancy::whereHas('company', function ($query) {
            $query->where('ownerId', auth()->user()->id);
        })->withCount('jobApplication as totalCount')
            ->having('totalCount', '>', 0)
            ->orderByDesc('totalCount')
            ->take(5)
            ->get()
            ->map(function ($job) {
                $conversionRate = $job->viewCount > 0
                    ? ($job->totalCount / $job->viewCount) * 100
                    : 0;
                return [
                    'title' => $job->title,
                    'viewCount' => $job->viewCount,
                    'totalCount' => $job->totalCount,
                    'conversionRate' => number_format($conversionRate, 2),
                ];
            });



        $analytics = [
            'activeUsers' =>  $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs'=> $mostAppliedJobs,
            'conversionRates' => $conversionRates
        ];
        return $analytics;
    }
}
