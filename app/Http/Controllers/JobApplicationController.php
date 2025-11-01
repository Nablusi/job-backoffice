<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Http\Requests\ApplicationUpdateRequest;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $query = JobApplication::with([
        'user' => fn($q) => $q->withTrashed(),
        'jobVacancy.company' => fn($q) => $q->withTrashed(),
    ])->latest();

    if (auth()->user()->role == 'company-owner') {
        $companyIds = auth()->user()->company->pluck('id')->toArray();

        if (!empty($companyIds)) {
            $query->whereHas('jobVacancy', function ($query) use ($companyIds) {
                $query->whereIn('companyId', $companyIds);
            });
        } else {
            $query->whereRaw('1 = 0');
        }
    }

    if ($request->input("archived") == "true") {
        $query->onlyTrashed();
    }

    $applications = $query->paginate(10)->onEachSide(1);

    return view("application.index", compact('applications', 'request'));
}


    public function show(string $id)
    {
        $application = JobApplication::findOrFail($id);
        return view("application.show", [
            'application' => $application,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $redirectToList = $request->query('redirectToList', 'true');
        $application = JobApplication::findOrFail($id);
        return view("application.edit", [
            'application' => $application,
            'redirectToList' => $redirectToList
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApplicationUpdateRequest $request, string $id)
    {
        $application = JobApplication::findOrFail($id);
        $application->update(
            [
                'status' => $request->input('status')
            ]
        );

        if ($request->input('redirectToList') == 'false') {
            return redirect()->route('job-applications.index');
        }

        return redirect()->route('job-applications.show', $application->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobApplication::findOrFail($id);
        $jobVacancy->delete();
        return redirect()->route("job-applications.index")->with("success", "Job application archived successfully.");
    }

    public function restore(string $id)
    {
        $jobVacancy = JobApplication::withTrashed()->findOrFail($id);
        $jobVacancy->restore();
        return redirect()->route("job-applications.index", ['archived' => 'true'])->with("success", "Job application restored successfully.");
    }
}
