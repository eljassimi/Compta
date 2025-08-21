<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of employees for a company.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\View\View
     */
    public function index(Company $company)
    {
        $employees = $company->employees;
        return view('employees.index', compact('company', 'employees'));
    }

    /**
     * Show the form for creating a new employee.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\View\View
     */
    public function create(Company $company)
    {
        return view('employees.form', compact('company'));
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Company $company)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cin' => ['required', 'string', 'max:255', 'unique:employees'],
            'cnss_number' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'date_of_hiring' => ['nullable', 'date'],
        ]);

        $company->employees()->create($request->only(['name', 'cin', 'cnss_number', 'job_title', 'date_of_hiring']));

        return redirect()->route('companies.employees.index', $company)->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified employee.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\View\View
     */
    public function edit(Company $company, Employee $employee)
    {
        return view('employees.form', compact('company', 'employee'));
    }

    /**
     * Update the specified employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Company $company, Employee $employee)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cin' => ['required', 'string', 'max:255', 'unique:employees,cin,' . $employee->id],
            'cnss_number' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'date_of_hiring' => ['nullable', 'date'],
        ]);

        $employee->update($request->only(['name', 'cin', 'cnss_number', 'job_title', 'date_of_hiring']));

        return redirect()->route('companies.employees.index', $company)->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Company $company, Employee $employee)
    {
        $employee->delete();

        return redirect()->route('companies.employees.index', $company)->with('success', 'Employee deleted successfully.');
    }
}