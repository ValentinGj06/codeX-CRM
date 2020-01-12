<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::paginate(10);
        return view ('companies.index')->with('companies', $companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Company::create($request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['email', 'unique:companies,email'],
            'logo' => ['nullable'],
            // 'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'dimensions:min_height=100', 'dimensions:min_width=100'],
            'website' => ['nullable']
        ]));
        // if($request->hasFile('logo')){
        //     $filenameWithExt = $request->file('logo')->getClientOriginalName();
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     $extension = $request->file('logo')->getClientOriginalExtension();
        //     $filenameToStore = $filename.'_'.time().'.'.$extension;
        //     $path = $request->file('logo')->storeAs('public/images', $filenameToStore);
        // }
   
        // $request->logo = $filenameToStore;

        return redirect('companies')->with('success', 'Company created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $employee = $company->employee()->paginate(10);
        return view('companies.show', compact('company', 'employee'));    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $company->update($request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['email', 'unique:companies,email'],
            'logo' => ['nullable'],
            // 'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'dimensions:min_height=100', 'dimensions:min_width=100'],
            'website' => ['nullable']
        ]));
        return redirect('companies')->with('success', 'Company updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect('companies')->with('success', 'Successfully deleted company!');        
    }
}
