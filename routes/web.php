<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login'); // Relies on Breeze auth routes
})->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('companies', CompanyController::class)->except(['show']);
    Route::resource('companies.employees', EmployeeController::class)->except(['show']);
    Route::get('companies/{company}/employees/{employee}/salaries', [SalaryController::class, 'index'])->name('salaries.index');
    Route::post('companies/{company}/employees/{employee}/salaries', [SalaryController::class, 'store'])->name('salaries.store');
    Route::get('companies/{company}/employees/{employee}/salaries/payslip', [SalaryController::class, 'payslip'])->name('salaries.payslip');
    Route::get('companies/{company}/employees/{employee}/salaries/payslip/download', [SalaryController::class, 'downloadPayslip'])->name('salaries.payslip.download');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalCompanies' => \App\Models\Company::count(),
            'totalEmployees' => \App\Models\Employee::count(),
            'averageSalary' => \App\Models\Salary::avg('base_salary') ?? 0,
        ]);
    })->name('dashboard');
});

require __DIR__.'/auth.php';