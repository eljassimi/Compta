<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class CompanyController extends Controller
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
     * Display a listing of companies.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $companies = Company::with(['employees.salaries'])->get()->map(function ($company) {
            $totalBaseSalary = $company->employees->sum(function ($employee) {
                return $employee->salaries->sum('base_salary');
            });
            $totalEmployeeContribution = $company->employees->sum(function ($employee) {
                return $employee->salaries->sum('employee_contribution');
            });
            $totalEmployerContribution = $company->employees->sum(function ($employee) {
                return $employee->salaries->sum('employer_contribution');
            });
            $totalIR = $company->employees->sum(function ($employee) {
                return $employee->salaries->sum('ir');
            });
            $totalNetSalary = $company->employees->sum(function ($employee) {
                return $employee->salaries->sum('net_salary');
            });

            $company->total_base_salary = $totalBaseSalary;
            $company->total_employee_contribution = $totalEmployeeContribution;
            $company->total_employer_contribution = $totalEmployerContribution;
            $company->total_ir = $totalIR;
            $company->total_net_salary = $totalNetSalary;
            return $company;
        });

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new company.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('companies.form');
    }

    /**
     * Store a newly created company in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ice' => ['nullable', 'string', 'max:255'],
            'if' => ['nullable', 'string', 'max:255'],
            'rc' => ['nullable', 'string', 'max:255'],
            'cnss_number' => ['nullable', 'string', 'max:255'],
        ]);

        Company::create($request->only(['name', 'ice', 'if', 'rc', 'cnss_number']));

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Show the form for editing the specified company.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\View\View
     */
    public function edit(Company $company)
    {
        return view('companies.form', compact('company'));
    }

    /**
     * Update the specified company in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ice' => ['nullable', 'string', 'max:255'],
            'if' => ['nullable', 'string', 'max:255'],
            'rc' => ['nullable', 'string', 'max:255'],
            'cnss_number' => ['nullable', 'string', 'max:255'],
        ]);

        $company->update($request->only(['name', 'ice', 'if', 'rc', 'cnss_number']));

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified company from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
