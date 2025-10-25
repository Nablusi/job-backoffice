<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Requests\CompanyCreateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class CompanyController extends Controller
{
    public $industries = ['Technology', 'Finance', 'Healthcare', 'Education', 'Manufacturing', 'Retail', 'Other'];

    public function index(Request $request)
    {
        //active
        $query = Company::latest();

        if ($request->input("archived") == "true") {
            $query->onlyTrashed();
        }

        $companies = $query->paginate(10)->onEachSide(1);
        // if I was on page 2, it will show me page number 3 and page number 1 => 1 on each side
        // show 10 items per page => paginate(10)
        // latest() => order by created_at desc

        return view("company.index", [
            'companies' => $companies,
            'request' => $request,
        ]);
        // compact() => ['categories' => $categories]  => associative array 
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
        return view("company.create", compact('industries'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validated = $request->validated();
        //company owner
        $owner = User::create([
            'name' => $validated['name'],
            'email' => $validated['owner_email'],
            'password' => Hash::make($validated['owner_password']),
            'role' => 'company-owner',
        ]);

        //return error if owner creation failed

        if (!$owner) {
            return redirect()->route('companies.create')->with('error', 'Failed to create owner!');
        }

        Company::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'],
            'ownerId' => $owner->id,
        ]);

        return redirect()->route("companies.index")->with("success", "company created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        $company = $this->getCompany($id);

        return view("company.show", compact("company"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id = null)
    {
        $industries = $this->industries;
        $redirectToList = $request->query('redirectToList', 'true');
        $company = $this->getCompany($id);
        return view('company.edit', compact('company', 'industries', 'redirectToList'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id = null)
    {
        $validated = $request->validated();
        $company = $this->getCompany($id);

        $company->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website']
        ]);

        //update owner
        $ownerData = [];
        $ownerData['name'] = $validated['owner_name'];

        if ($validated['owner_password']) {
            $ownerData['password'] = Hash::make($validated['owner_password']);

        }

        $company->owner->update($ownerData);

        if (auth()->user()->role == 'company-owner') {
            return redirect()->route('my-company.show')->with('success', 'Company details updated successfully.');
        }


        if ($request->input('redirectToList') == 'false') {
            return redirect()
                ->route('companies.show', $id)
                ->with('success', 'Company details updated successfully.');
        }

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Company::findOrFail($id);
        $category->delete();
        return redirect()->route("companies.index")->with("success", "Job category archived successfully.");
        // --- IGNORE ---
    }

    // restore function
    public function restore($id)
    {
        $category = Company::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route("companies.index", ['archived' => 'true'])->with("success", "company restored successfully.");
        // --- IGNORE ---   
    }

    private function getCompany(string $id = null)
    {
        if ($id) {
            return Company::findOrFail($id);
        } else {
            return Company::where('ownerId', auth()->user()->id)->first();
        }
    }
}
