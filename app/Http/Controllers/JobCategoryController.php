<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryUpdateRequset;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //active
        $query = JobCategory::latest();

        if ($request->input("archived") == "true") {
            $query->onlyTrashed();
        }

        //ar

        $categories = $query->paginate(10)->onEachSide(1);
        // if I was on page 2, it will show me page number 3 and page number 1 => 1 on each side
        // show 10 items per page => paginate(10)
        // latest() => order by created_at desc

        return view("category.index", [
            'categories' => $categories,
            'request' => $request,
        ]);
        // compact() => ['categories' => $categories]  => associative array 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("category.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        $validated = $request->validated();
        JobCategory::create($validated);
        return redirect()->route("job-categories.index")->with("success", "Job category created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = JobCategory::findOrFail($id);
        return view("category.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequset $request, string $id)
    {
        $validated = $request->validated();
        $category = JobCategory::findOrFail($id);
        $category->update($validated);
        return redirect()->route("job-categories.index")->with("success", "Job category updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = JobCategory::findOrFail($id);
        $category->delete();
        return redirect()->route("job-categories.index")->with("success", "Job category archived successfully.");
        // --- IGNORE ---
    }

    // restore function
    public function restore($id)
    {
        $category = JobCategory::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route("job-categories.index", ['archived' => 'true'])->with("success", "Job category restored successfully.");
    // --- IGNORE ---   
    }
}
