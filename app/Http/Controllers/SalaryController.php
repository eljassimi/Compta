<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function store(Request $request, Company $company, Employee $employee)
    {
        $data = $request->validate([
            'base_salary' => ['required', 'numeric', 'min:0'],
            'employee_contribution' => ['required', 'numeric', 'min:0'],
            'employer_contribution' => ['required', 'numeric', 'min:0'],
            'ir' => ['required', 'numeric', 'min:0'],
            'net_salary' => ['required', 'numeric', 'min:0'],
            'bonus' => ['nullable', 'numeric', 'min:0'],
            'deduction' => ['nullable', 'numeric', 'min:0'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer', 'min:2000', 'max:2030'],
        ]);

        // Optionally re-validate calculations to ensure consistency
        $grossSalary = $data['base_salary'] + ($data['bonus'] ?? 0) - ($data['deduction'] ?? 0);
        $calculatedData = $this->calculateNetSalary($grossSalary, $data['base_salary']);

        // Compare frontend calculations with backend to ensure accuracy
        if (
            abs($data['employee_contribution'] - $calculatedData['employee_contribution']) > 0.01 ||
            abs($data['employer_contribution'] - $calculatedData['employer_contribution']) > 0.01 ||
            abs($data['ir'] - $calculatedData['ir']) > 0.01 ||
            abs($data['net_salary'] - $calculatedData['net_salary']) > 0.01
        ) {
            return redirect()->route('salaries.index', [$company, $employee])
                ->withErrors(['error' => 'Calculation mismatch. Please try again.'])
                ->withInput();
        }

        // Check if a salary record exists for the employee, month, and year
        $salary = $employee->salaries()
            ->where('month', $data['month'])
            ->where('year', $data['year'])
            ->first();

        if ($salary) {
            // Update existing record
            $updated = $salary->update([
                'base_salary' => $data['base_salary'],
                'employee_contribution' => $data['employee_contribution'],
                'employer_contribution' => $data['employer_contribution'],
                'ir' => $data['ir'],
                'net_salary' => $data['net_salary'],
                'bonus' => $data['bonus'] ?? 0,
                'deduction' => $data['deduction'] ?? 0,
                'month' => $data['month'],
                'year' => $data['year'],
            ]);

            if ($updated) {
                return redirect()->route('salaries.index', [$company, $employee])
                    ->with('success', 'Salary updated successfully.');
            } else {
                return redirect()->route('salaries.index', [$company, $employee])
                    ->withErrors(['error' => 'Failed to update salary. Please try again.'])
                    ->withInput();
            }
        } else {
            // Create new record
            $created = $employee->salaries()->create([
                'employee_id' => $employee->id,
                'base_salary' => $data['base_salary'],
                'employee_contribution' => $data['employee_contribution'],
                'employer_contribution' => $data['employer_contribution'],
                'ir' => $data['ir'],
                'net_salary' => $data['net_salary'],
                'bonus' => $data['bonus'] ?? 0,
                'deduction' => $data['deduction'] ?? 0,
                'month' => $data['month'],
                'year' => $data['year'],
            ]);

            if ($created) {
                return redirect()->route('salaries.index', [$company, $employee])
                    ->with('success', 'Salary saved successfully.');
            } else {
                return redirect()->route('salaries.index', [$company, $employee])
                    ->withErrors(['error' => 'Failed to save salary. Please try again.'])
                    ->withInput();
            }
        }
    }

    protected function calculateNetSalary($grossSalary, $baseSalary)
    {
        // Employee Contributions (Deductions)
        $cnssEmployee = min(0.0448 * $grossSalary, 271.80);
        $amoEmployee = min(0.0226 * $grossSalary, 135.60);

        // Calculate Professional Fees (Frais Professionnels)
        $annualBaseSalary = $baseSalary * 12;
        $professionalFeesRate = $annualBaseSalary > 78000 ? 0.25 : 0.35;
        $professionalFees = $baseSalary * $professionalFeesRate;

        // Calculate Net Taxable Income (Net Imposable)
        $netTaxable = $grossSalary - $professionalFees - ($cnssEmployee + $amoEmployee);

        // Calculate IR using Moroccan tax brackets
        $irMonthly = 0;
        if ($netTaxable > 0) {
            if ($netTaxable <= 3333) {
                $irMonthly = 0;
            } elseif ($netTaxable <= 5000) {
                $irMonthly = ($netTaxable * 0.10) - 333.33;
            } elseif ($netTaxable <= 6667) {
                $irMonthly = ($netTaxable * 0.20) - 833.33;
            } elseif ($netTaxable <= 8333) {
                $irMonthly = ($netTaxable * 0.30) - 1500.00;
            } elseif ($netTaxable <= 15000) {
                $irMonthly = ($netTaxable * 0.34) - 1833.33;
            } else {
                $irMonthly = ($netTaxable * 0.37) - 2283.33;
            }
            $irMonthly = max($irMonthly, 0);
        }

        $totalDeduction = $cnssEmployee + $amoEmployee + $irMonthly;
        $netSalary = $grossSalary - $totalDeduction;

        // Employer Contributions
        $cnssEmployer = min(0.0898 * $grossSalary, 748.80);
        $afEmployer = min(0.0640 * $grossSalary, 748.80);
        $tfpEmployer = min(0.0160 * $grossSalary, 748.80);
        $participationAmoEmployer = min(0.0185 * $grossSalary, 748.80);
        $amoEmployer = min(0.0226 * $grossSalary, 226.20);

        $employeeContribution = $cnssEmployee + $amoEmployee + $irMonthly;
        $employerContribution = $cnssEmployer + $afEmployer + $tfpEmployer + $participationAmoEmployer + $amoEmployer;

        return [
            'employee_contribution' => round($employeeContribution, 2),
            'employer_contribution' => round($employerContribution, 2),
            'ir' => round($irMonthly, 2),
            'net_salary' => round($netSalary, 2),
        ];
    }

    public function payslip(Company $company, Employee $employee)
    {
        $salary = $employee->salaries()->latest()->first();
        return view('salaries.payslip', compact('company', 'employee', 'salary'));
    }
        public function index(Company $company, Employee $employee)
    {
        $salary = $employee->salaries()->latest()->first(); 
        return view('salaries.index', compact('company', 'employee', 'salary'));
    }
}