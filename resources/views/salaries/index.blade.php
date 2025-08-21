<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Salary Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8'
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'pulse-soft': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
 youtube.com/watch?v=3bGDeR0uD3M&t=1346s        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .dark .glass-effect {
            background: rgba(31, 41, 55, 0.95);
        }
        .input-focus {
            transition: all 0.3s ease;
        }
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .number-animate {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="max-w-6xl mx-auto px-6 mb-6">
            <div class="bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-xl p-4 flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="max-w-6xl mx-auto px-6 mbstick:mb-6">
            <div class="bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-xl p-4">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <ul class="text-red-800 dark:text-red-200">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Hidden Form for Submission to Backend -->
    <form id="hidden-salary-form" action="{{ route('salaries.store', [$company, $employee]) }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
        <input type="hidden" name="base_salary" id="hidden_base_salary">
        <input type="hidden" name="employee_contribution" id="hidden_employee_contribution">
        <input type="hidden" name="employer_contribution" id="hidden_employer_contribution">
        <input type="hidden" name="ir" id="hidden_ir">
        <input type="hidden" name="net_salary" id="hidden_net_salary">
        <input type="hidden" name="bonus" id="hidden_bonus">
        <input type="hidden" name="deduction" id="hidden_deduction" value="0.00">
        <input type="hidden" name="month" id="hidden_month">
        <input type="hidden" name="year" id="hidden_year">
    </form>

    <!-- Header -->
    <div class="gradient-bg p-6 mb-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between text-white">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-calculator text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Salary Management</h1>
                        <p class="text-blue-100">Employee: {{ $employee->name ?? 'John Doe' }}</p>
                    </div>
                </div>
                <button onclick="toggleDarkMode()" class="bg-white/20 hover:bg-white/30 p-3 rounded-xl transition-colors">
                    <i class="fas fa-moon text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 pb-12">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Input Form -->
            <div class="lg:col-span-1">
                <div class="glass-effect rounded-2xl shadow-xl border border-white/20 p-8 card-hover animate-fade-in">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                            <i class="fas fa-edit text-primary-500 mr-3"></i>
                            Salary Details
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">Enter the salary information below</p>
                    </div>

                    <form id="salary-form" class="space-y-6">
                        <!-- Base Salary -->
                        <div class="space-y-2">
                            <label for="base_salary" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <i class="fas fa-money-bill-wave text-green-500 mr-2"></i>
                                Base Salary (MAD)
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       id="base_salary" 
                                       name="base_salary" 
                                       value="{{ $salary->base_salary ?? '15000' }}"
                                       class="input-focus w-full px-4 py-4 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-lg font-medium focus:border-primary-500 focus:ring-0 transition-all duration-300" 
                                       required 
                                       step="0.01" 
                                       oninput="calculateSalary()"
                                       placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                    <span class="text-gray-400 font-medium">MAD</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bonus -->
                        <div class="space-y-2">
                            <label for="bonus" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <i class="fas fa-gift text-yellow-500 mr-2"></i>
                                Bonus (MAD)
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       id="bonus" 
                                       name="bonus" 
                                       value="{{ $salary->bonus ?? '2000' }}"
                                       class="input-focus w-full px-4 py-4 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-lg font-medium focus:border-primary-500 focus:ring-0 transition-all duration-300" 
                                       step="0.01" 
                                       oninput="calculateSalary()"
                                       placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                    <span class="text-gray-400 font-medium">MAD</span>
                                </div>
                            </div>
                        </div>

                        <!-- Month & Year -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="month" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                    Month
                                </label>
                                <select id="month" name="month" class="input-focus w-full px-4 py-4 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-lg font-medium focus:border-primary-500 focus:ring-0" required>
                                    <option value="" disabled>Select Month</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ (old('month', $salary->month ?? date('n')) == $i) ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label for="year" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-calendar-alt text-purple-500 mr-2"></i>
                                    Year
                                </label>
                                <input type="number" 
                                       id="year" 
                                       name="year" 
                                       value="{{ old('year', $salary->year ?? date('Y')) }}" 
                                       class="input-focus w-full px-4 py-4 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-lg font-medium focus:border-primary-500 focus:ring-0" 
                                       required 
                                       min="2000" 
                                       max="2030">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3 pt-4">
                            <button type="submit" id="save-salary-btn" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-save mr-2"></i>
                                Save Salary
                            </button>
                            <a href="{{ route('salaries.payslip', [$company, $employee]) }}" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 text-center block">
                                <i class="fas fa-file-pdf mr-2"></i>
                                Preview Payslip
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Salary Breakdown -->
            <div class="lg:col-span-2">
                <div class="glass-effect rounded-2xl shadow-xl border border-white/20 p-8 card-hover animate-fade-in">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                            <i class="fas fa-chart-pie text-primary-500 mr-3"></i>
                            Salary Breakdown
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">Detailed calculation of salary components</p>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm font-medium">Gross Salary</p>
                                    <p class="text-2xl font-bold number-animate"><span id="gross_salary">0</span> MAD</p>
                                </div>
                                <i class="fas fa-wallet text-3xl text-green-200"></i>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-red-100 text-sm font-medium">Total Deductions</p>
                                    <p class="text-2xl font-bold number-animate"><span id="total_deductions">0</span> MAD</p>
                                </div>
                                <i class="fas fa-minus-circle text-3xl text-red-200"></i>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm font-medium">Net Salary</p>
                                    <p class="text-2xl font-bold number-animate"><span id="net_salary">0</span> MAD</p>
                                </div>
                                <i class="fas fa-hand-holding-usd text-3xl text-blue-200"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Breakdown -->
                    <div class="space-y-6">
                        <!-- Employee Deductions -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-user text-blue-500 mr-3"></i>
                                Employee Deductions
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">CNSS (4.48%)</span>
                                    <span class="font-bold text-gray-900 dark:text-white"><span id="cnss_employee">0</span> MAD</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">AMO (2.26%)</span>
                                    <span class="font-bold text-gray-900 dark:text-white"><span id="amo_employee">0</span> MAD</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-700">
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Professional Fees</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">(<span id="prof_fees_rate">35</span>% of base salary)</p>
                                    </div>
                                    <span class="font-bold text-blue-600 dark:text-blue-400"><span id="professional_fees">0</span> MAD</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg border border-yellow-200 dark:border-yellow-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Net Taxable Income</span>
                                    <span class="font-bold text-yellow-600 dark:text-yellow-400"><span id="net_taxable">0</span> MAD</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-red-50 dark:bg-red-900/30 rounded-lg border border-red-200 dark:border-red-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Income Tax (IR)</span>
                                    <span class="font-bold text-red-600 dark:text-red-400"><span id="ir">0</span> MAD</span>
                                </div>
                            </div>
                        </div>

                        <!-- Employer Contributions -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-building text-green-500 mr-3"></i>
                                Employer Contributions
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">CNSS (8.98%)</span>
                                    <span class="font-bold text-gray-900 dark:text-white"><span id="cnss_employer">0</span> MAD</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">AF (6.40%)</span>
                                    <span class="font-bold text-gray-900 dark:text-white"><span id="af_employer">0</span> MAD</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">TFP (1.60%)</span>
                                    <span class="font-bold text-gray-900 dark:text-white"><span id="tfp_employer">0</span> MAD</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Participation AMO (1.85%)</span>
                                    <span class="font-bold text-gray-900 dark:text-white"><span id="participation_amo_employer">0</span> MAD</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">AMO (2.26%)</span>
                                    <span class="font-bold text-gray-900 dark:text-white"><span id="amo_employer">0</span> MAD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateSalary() {
            const baseSalary = parseFloat(document.getElementById('base_salary').value) || 0;
            const bonus = parseFloat(document.getElementById('bonus').value) || 0;
            const grossSalary = baseSalary + bonus;

            // Employee Contributions (Deductions)
            const cnssEmployee = Math.min(0.0448 * grossSalary);
            const amoEmployee = Math.min(0.0226 * grossSalary);
            const deductions = cnssEmployee + amoEmployee;

            // Employer Contributions
            const cnssEmployer = Math.min(0.0898 * grossSalary);
            const afEmployer = Math.min(0.0640 * grossSalary);
            const tfpEmployer = Math.min(0.0160 * grossSalary);
            const participationAmoEmployer = Math.min(0.0185 * grossSalary);
            const amoEmployer = Math.min(0.0226 * grossSalary);

            // Calculate Professional Fees (Frais Professionnels)
            const annualBaseSalary = baseSalary * 12;
            const professionalFeesRate = annualBaseSalary > 78000 ? 0.25 : 0.35;
            const professionalFees = baseSalary * professionalFeesRate;

            // Calculate Net Taxable Income (Net Imposable)
            const netTaxable = grossSalary - professionalFees - deductions;

            // Calculate IR using the Moroccan tax brackets
            let irMonthly = 0;
            if (netTaxable > 0) {
                if (netTaxable <= 3333) {
                    irMonthly = 0;
                } else if (netTaxable <= 5000) {
                    irMonthly = (netTaxable * 0.10) - 333.33;
                } else if (netTaxable <= 6667) {
                    irMonthly = (netTaxable * 0.20) - 833.33;
                } else if (netTaxable <= 8333) {
                    irMonthly = (netTaxable * 0.30) - 1500.00;
                } else if (netTaxable <= 15000) {
                    irMonthly = (netTaxable * 0.34) - 1833.33;
                } else {
                    irMonthly = (netTaxable * 0.37) - 2283.33;
                }
                
                // Ensure IR is not negative
                irMonthly = Math.max(irMonthly, 0);
            }

            const totalDeduction = cnssEmployee + amoEmployee + irMonthly;
            const netSalary = grossSalary - totalDeduction;

            // Update display with animation
            updateValue('gross_salary', grossSalary);
            updateValue('cnss_employee', cnssEmployee);
            updateValue('amo_employee', amoEmployee);
            updateValue('professional_fees', professionalFees);
            updateValue('net_taxable', netTaxable);
            updateValue('ir', irMonthly);
            updateValue('total_deductions', totalDeduction);
            updateValue('cnss_employer', cnssEmployer);
            updateValue('af_employer', afEmployer);
            updateValue('tfp_employer', tfpEmployer);
            updateValue('participation_amo_employer', participationAmoEmployer);
            updateValue('amo_employer', amoEmployer);
            updateValue('net_salary', netSalary);
            
            // Update professional fees rate display
            document.getElementById('prof_fees_rate').textContent = Math.round(professionalFeesRate * 100);
        }

        function updateValue(elementId, value) {
            const element = document.getElementById(elementId);
            const formattedValue = value.toFixed(2);
            if (element.textContent !== formattedValue) {
                element.style.transform = 'scale(1.1)';
                element.style.color = '#3b82f6';
                setTimeout(() => {
                    element.textContent = formattedValue;
                    element.style.transform = 'scale(1)';
                    element.style.color = '';
                }, 150);
            }
        }

        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            const icon = document.querySelector('button i');
            if (document.documentElement.classList.contains('dark')) {
                icon.className = 'fas fa-sun text-xl';
            } else {
                icon.className = 'fas fa-moon text-xl';
            }
        }

        // Initialize calculations
        document.addEventListener('DOMContentLoaded', function() {
            calculateSalary();
            
            // Add input event listeners
            document.querySelectorAll('#base_salary, #bonus').forEach(input => {
                input.addEventListener('input', calculateSalary);
            });

            // Add form submission handler
            document.getElementById('salary-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Populate hidden form
                document.getElementById('hidden_base_salary').value = parseFloat(document.getElementById('base_salary').value) || 0;
                document.getElementById('hidden_bonus').value = parseFloat(document.getElementById('bonus').value) || 0;
                document.getElementById('hidden_month').value = document.getElementById('month').value;
                document.getElementById('hidden_year').value = document.getElementById('year').value;
                document.getElementById('hidden_ir').value = parseFloat(document.getElementById('ir').textContent) || 0;
                document.getElementById('hidden_net_salary').value = parseFloat(document.getElementById('net_salary').textContent) || 0;
                document.getElementById('hidden_employee_contribution').value = (
                    (parseFloat(document.getElementById('cnss_employee').textContent) || 0) +
                    (parseFloat(document.getElementById('amo_employee').textContent) || 0)
                ).toFixed(2);
                document.getElementById('hidden_employer_contribution').value = (
                    (parseFloat(document.getElementById('cnss_employer').textContent) || 0) +
                    (parseFloat(document.getElementById('af_employer').textContent) || 0) +
                    (parseFloat(document.getElementById('tfp_employer').textContent) || 0) +
                    (parseFloat(document.getElementById('participation_amo_employer').textContent) || 0) +
                    (parseFloat(document.getElementById('amo_employer').textContent) || 0)
                ).toFixed(2);

                // Show success message
                const button = e.target.querySelector('#save-salary-btn');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check mr-2"></i>Saved Successfully!';
                button.classList.add('bg-green-500', 'hover:bg-green-600');
                
                // Submit hidden form
                document.getElementById('hidden-salary-form').submit();

                // Revert button state
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-500', 'hover:bg-green-600');
                }, 2000);
            });
        });
    </script>
</body>
</html>