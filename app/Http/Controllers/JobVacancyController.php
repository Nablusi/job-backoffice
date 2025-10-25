<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Company;
use App\Models\JobCategory;
use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;

class JobVacancyController extends Controller
{
    public function index(Request $request)
    {
        //active
        $query = JobVacancy::latest();

        if (auth()->user()->role == 'company-owner') {
            $companyIds = auth()->user()->company->pluck('id')->toArray();

            if (!empty($companyIds)) {
                $query->whereIn('companyId', $companyIds);
            } else {
                $query->whereRaw('1 = 0'); // لو ما عنده شركات، ما يظهر شيء
            }
        }

        if ($request->input("archived") == "true") {
            $query->onlyTrashed();
        }

        $jobVacancies = $query->paginate(10)->onEachSide(1);
        return view("job-vacancy.index", [
            'jobVacancies' => $jobVacancies,
            'request' => $request,
        ]);
    }
    public function create()
    {
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        return view("job-vacancy.create", compact('companies', 'jobCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validated = $request->validated();
        JobVacancy::create($validated);
        return redirect()->route("job-vacancies.index")->with("success", "Job vacancy created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view("job-vacancy.show", compact("jobVacancy"));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        $redirectToList = $request->query('redirectToList', 'true');
        return view("job-vacancy.edit", compact("jobVacancy", 'redirectToList', 'companies', 'jobCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->update($validated);

        if ($request->input('redirectToList') == 'true') {
            return redirect()->route("job-vacancies.show", $jobVacancy->id)->with("success", "Job vacancy updated successfully.");
        }
        return redirect()->route("job-vacancies.index")->with("success", "Job vacancy updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();
        return redirect()->route("job-vacancies.index")->with("success", "Job vacancy archived successfully.");
    }

    public function restore(string $id)
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();
        return redirect()->route("job-vacancies.index", ['archived' => 'true'])->with("success", "Job vacancy restored successfully.");
    }
}
