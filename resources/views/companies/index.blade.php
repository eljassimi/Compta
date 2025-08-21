@extends('layouts.app')
@section('title', 'Companies')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Companies</h1>
                    <p class="text-gray-600 dark:text-gray-400">Manage your company directory and information</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="searchInput"
                            placeholder="Search companies..." 
                            class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 w-64"
                            oninput="filterCompanies()"
                        >
                    </div>
                    
                    <!-- Add Company Button -->
                    <a href="{{ route('companies.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-xl transition-all duration-200 transform hover:scale-[1.02] hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Company
                    </a>
                </div>
            </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-6 transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Companies</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $companies->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-6 transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Companies</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $companies->where('status', 'active')->count() ?? $companies->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-6 transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Industries</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $companies->pluck('industry')->unique()->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-6 transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Employees</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $companies->sum('employees_count') ?? '1,247' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6">
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-2">
                <div class="flex space-x-1" role="tablist">
                    <button onclick="filterByStatus('all')" class="filter-tab active px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200" data-status="all">
                        All Companies
                    </button>
                    <button onclick="filterByStatus('technology')" class="filter-tab px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200" data-status="technology">
                        Technology
                    </button>
                    <button onclick="filterByStatus('finance')" class="filter-tab px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200" data-status="finance">
                        Finance
                    </button>
                    <button onclick="filterByStatus('healthcare')" class="filter-tab px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200" data-status="healthcare">
                        Healthcare
                    </button>
                    <button onclick="filterByStatus('other')" class="filter-tab px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200" data-status="other">
                        Other
                    </button>
                </div>
            </div>
        </div>

        <!-- Companies Grid/Table -->
        <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
            
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Company Directory</h3>
                    <div class="flex items-center space-x-2">
                        <!-- View Toggle -->
                        <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                            <button onclick="toggleView('grid')" id="gridViewBtn" class="view-btn active p-2 rounded-md transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                            <button onclick="toggleView('table')" id="tableViewBtn" class="view-btn p-2 rounded-md transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Sort Dropdown -->
                        <select onchange="sortCompanies(this.value)" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="name">Sort by Name</option>
                            <option value="industry">Sort by Industry</option>
                            <option value="employees">Sort by Employees</option>
                            <option value="created">Sort by Date</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Grid View -->
            <div id="gridView" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="companiesGrid">
                    @foreach ($companies as $company)
                    <div class="company-card bg-white dark:bg-gray-700 rounded-xl shadow-lg border border-gray-200 dark:border-gray-600 p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02]" data-industry="{{ strtolower($company->industry ?? 'other') }}" data-name="{{ strtolower($company->name) }}" data-total-sb="{{ $company->total_base_salary ?? 0 }}" data-total-cot-pp="{{ $company->total_employer_contribution ?? 0 }}" data-total-cot-sp="{{ $company->total_employee_contribution ?? 0 }}" data-total-ir="{{ $company->total_ir ?? 0 }}" data-total-net="{{ $company->total_net_salary ?? 0 }}">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">{{ substr($company->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $company->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $company->industry ?? 'Technology' }}</p>
                                </div>
                            </div>
                            <div class="relative">
                                <button onclick="toggleDropdown('dropdown-{{ $company->id }}')" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                </button>
                                <div id="dropdown-{{ $company->id }}" class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 z-10">
                                    <a href="{{ route('companies.employees.index', $company->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-t-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        View Employees
                                    </a>
                                    <a href="{{ route('companies.edit', $company->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Company
                                    </a>
                                    <button onclick="confirmDelete('{{ $company->name }}', '{{ route('companies.destroy', $company->id) }}')" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-b-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete Company
                                    </button>
                                    <button onclick="toggleAccountingSheet('{{ $company->id }}')" class="flex items-center w-full px-4 py-2 text-sm text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-b-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        Fiche de Comptabilisation
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Employees</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $company->employees_count ?? rand(10, 500) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Founded</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $company->founded_year ?? '2020' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Status</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Industry</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Employees</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="companiesTable">
                            @foreach ($companies as $company)
                            <tr class="company-row hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200" data-industry="{{ strtolower($company->industry ?? 'other') }}" data-name="{{ strtolower($company->name) }}" data-total-sb="{{ $company->total_base_salary ?? 0 }}" data-total-cot-pp="{{ $company->total_employer_contribution ?? 0 }}" data-total-cot-sp="{{ $company->total_employee_contribution ?? 0 }}" data-total-ir="{{ $company->total_ir ?? 0 }}" data-total-net="{{ $company->total_net_salary ?? 0 }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                            <span class="text-white font-bold">{{ substr($company->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $company->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $company->email ?? 'contact@' . strtolower(str_replace(' ', '', $company->name)) . '.com' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $company->industry ?? 'Technology' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $company->employees_count ?? rand(10, 500) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('companies.employees.index', $company->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition-colors duration-200">Employees</a>
                                    <a href="{{ route('companies.edit', $company->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors duration-200">Edit</a>
                                    <button onclick="confirmDelete('{{ $company->name }}', '{{ route('companies.destroy', $company->id) }}')" class="text-red-600 hover:text-red-900 dark:hover:text-red-300 transition-colors duration-200">Delete</button>
                                    <button onclick="toggleAccountingSheet('{{ $company->id }}')" class="text-green-600 hover:text-green-900 dark:hover:text-green-300 transition-colors duration-200">Fiche de Comptabilisation</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($companies, 'links'))
        <div class="mt-6">
            {{ $companies->links() }}
        </div>
        @endif

    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mt-4">Delete Company</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400" id="deleteMessage">
                    Are you sure you want to delete this company? This action cannot be undone.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-lg w-24 hover:bg-red-600 transition-colors duration-200 mr-2">
                        Delete
                    </button>
                </form>
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-base font-medium rounded-lg w-24 hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Accounting Sheet Modal -->
<div id="accountingSheetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-3/4 max-w-4xl shadow-lg rounded-2xl bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900">
                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mt-4">Fiche de Comptabilisation - <span id="modalCompanyName"></span></h3>
            <div class="mt-4">
                <table class="min-w-full bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Plan Comptable</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Débit</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Crédit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">TOTAL SB</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right">61711</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="debitSB">0.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="creditSB">0.00</td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">TOTAL COT PP</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right">64511</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="debitCotPP">0.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="creditCotPP">0.00</td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">COT PP + SP</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right">43111</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="debitCotPPSP">0.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="creditCotPPSP">0.00</td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">TOTAL IR</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right">44571</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="debitIR">0.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="creditIR">0.00</td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">TOTAL SALAIRE NET</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right">42111</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="debitNet">0.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="creditNet">0.00</td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600 font-bold">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Result</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="totalDebit">0.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right" id="totalCredit">0.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="items-center px-4 py-3 mt-4">
                <button onclick="closeAccountingSheet()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-base font-medium rounded-lg w-24 hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .filter-tab.active {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .filter-tab:not(.active) {
        color: #6b7280;
    }
    
    .filter-tab:not(.active):hover {
        background-color: #f3f4f6;
        color: #374151;
    }
    
    .dark .filter-tab:not(.active) {
        color: #9ca3af;
    }
    
    .dark .filter-tab:not(.active):hover {
        background-color: #374151;
        color: #d1d5db;
    }
    
    .view-btn.active {
        background-color: #3b82f6;
        color: white;
    }
    
    .view-btn:not(.active) {
        color: #6b7280;
    }
    
    .view-btn:not(.active):hover {
        background-color: #e5e7eb;
        color: #374151;
    }
    
    .dark .view-btn:not(.active) {
        color: #9ca3af;
    }
    
    .dark .view-btn:not(.active):hover {
        background-color: #4b5563;
        color: #d1d5db;
    }
    
    .dropdown-menu {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .company-card {
        animation: fadeIn 0.3s ease-out;
    }
</style>

<script type="text/javascript">
    var gk_isXlsx = false;
    var gk_xlsxFileLookup = {};
    var gk_fileData = {};
    function filledCell(cell) {
      return cell !== '' && cell != null;
    }
    function loadFileData(filename) {
    if (gk_isXlsx && gk_xlsxFileLookup[filename]) {
        try {
            var workbook = XLSX.read(gk_fileData[filename], { type: 'base64' });
            var firstSheetName = workbook.SheetNames[0];
            var worksheet = workbook.Sheets[firstSheetName];
            // Convert sheet to JSON to filter blank rows
            var jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1, blankrows: false, defval: '' });
            // Filter out blank rows (rows where all cells are empty, null, or undefined)
            var filteredData = jsonData.filter(row => row.some(filledCell));
            // Heuristic to find the header row by ignoring rows with fewer filled cells than the next row
            var headerRowIndex = filteredData.findIndex((row, index) =>
              row.filter(filledCell).length >= filteredData[index + 1]?.filter(filledCell).length
            );
            // Fallback
            if (headerRowIndex === -1 || headerRowIndex > 25) {
              headerRowIndex = 0;
            }
            // Convert filtered JSON back to CSV
            var csv = XLSX.utils.aoa_to_sheet(filteredData.slice(headerRowIndex)); // Create a new sheet from filtered array of arrays
            csv = XLSX.utils.sheet_to_csv(csv, { header: 1 });
            return csv;
        } catch (e) {
            console.error(e);
            return "";
        }
    }
    return gk_fileData[filename] || "";
    }

    let currentView = 'grid';
    let currentFilter = 'all';
    
    // Filter companies by search
    function filterCompanies() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const cards = document.querySelectorAll('.company-card');
        const rows = document.querySelectorAll('.company-row');
        
        cards.forEach(card => {
            const name = card.dataset.name;
            const industry = card.dataset.industry;
            const visible = name.includes(searchTerm) || industry.includes(searchTerm);
            card.style.display = visible ? 'block' : 'none';
        });
        
        rows.forEach(row => {
            const name = row.dataset.name;
            const industry = row.dataset.industry;
            const visible = name.includes(searchTerm) || industry.includes(searchTerm);
            row.style.display = visible ? 'table-row' : 'none';
        });
    }
    
    // Filter by industry
    function filterByStatus(industry) {
        currentFilter = industry;
        
        // Update active tab
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelector(`[data-status="${industry}"]`).classList.add('active');
        
        const cards = document.querySelectorAll('.company-card');
        const rows = document.querySelectorAll('.company-row');
        
        cards.forEach(card => {
            const cardIndustry = card.dataset.industry;
            const visible = industry === 'all' || cardIndustry === industry;
            card.style.display = visible ? 'block' : 'none';
        });
        
        rows.forEach(row => {
            const rowIndustry = row.dataset.industry;
            const visible = industry === 'all' || rowIndustry === industry;
            row.style.display = visible ? 'table-row' : 'none';
        });
    }
    
    // Toggle between grid and table view
    function toggleView(view) {
        currentView = view;
        
        // Update active button
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.getElementById(view + 'ViewBtn').classList.add('active');
        
        // Show/hide views
        if (view === 'grid') {
            document.getElementById('gridView').classList.remove('hidden');
            document.getElementById('tableView').classList.add('hidden');
        } else {
            document.getElementById('gridView').classList.add('hidden');
            document.getElementById('tableView').classList.remove('hidden');
        }
    }
    
    // Sort companies
    function sortCompanies(criteria) {
        const container = currentView === 'grid' ? 
            document.getElementById('companiesGrid') : 
            document.getElementById('companiesTable');
        
        const items = Array.from(container.children);
        
        items.sort((a, b) => {
            let aValue, bValue;
            
            switch(criteria) {
                case 'name':
                    aValue = a.dataset.name;
                    bValue = b.dataset.name;
                    break;
                case 'industry':
                    aValue = a.dataset.industry;
                    bValue = b.dataset.industry;
                    break;
                case 'employees':
                    aValue = parseInt(a.querySelector('.text-sm.font-medium').textContent) || 0;
                    bValue = parseInt(b.querySelector('.text-sm.font-medium').textContent) || 0;
                    return bValue - aValue; // Descending order for numbers
                default:
                    return 0;
            }
            
            return aValue.localeCompare(bValue);
        });
        
        items.forEach(item => container.appendChild(item));
    }
    
    // Toggle dropdown menu
    function toggleDropdown(dropdownId) {
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu.id !== dropdownId) {
                menu.classList.add('hidden');
            }
        });
        
        // Toggle current dropdown
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.relative')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
    
    // Confirm delete
    function confirmDelete(companyName, deleteUrl) {
        document.getElementById('deleteMessage').textContent = 
            `Are you sure you want to delete "${companyName}"? This action cannot be undone.`;
        document.getElementById('deleteForm').action = deleteUrl;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    // Close delete modal
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
    
    // Toggle Accounting Sheet Modal
    function toggleAccountingSheet(companyId) {
        const modal = document.getElementById('accountingSheetModal');
        const companyElement = document.querySelector(`[data-name="${companyId}"]`) || document.getElementById(`dropdown-${companyId}`)?.closest('.company-card, .company-row');

        if (companyElement) {
            const companyName = companyElement.querySelector('h4, div.text-sm.font-medium')?.textContent || 'Unknown Company';
            const totalSB = parseFloat(companyElement.dataset.totalSb) || 0;
            const totalCotPP = parseFloat(companyElement.dataset.totalCotPp) || 0;
            const totalCotSP = parseFloat(companyElement.dataset.totalCotSp) || 0;
            const totalIR = parseFloat(companyElement.dataset.totalIr) || 0;
            const totalNet = parseFloat(companyElement.dataset.totalNet) || 0;

            // Populate modal
            document.getElementById('modalCompanyName').textContent = companyName;
            document.getElementById('debitSB').textContent = totalSB.toFixed(2); // Debit for salaries
            document.getElementById('creditSB').textContent = '0.00';

            document.getElementById('debitCotPP').textContent = totalCotPP.toFixed(2); // Debit for employer contribution
            document.getElementById('creditCotPP').textContent = '0.00';

            document.getElementById('debitCotPPSP').textContent = '0.00';
            document.getElementById('creditCotPPSP').textContent = (totalCotPP + totalCotSP).toFixed(2); // Credit for total contributions

            document.getElementById('debitIR').textContent = '0.00';
            document.getElementById('creditIR').textContent = totalIR.toFixed(2); // Credit for tax

            document.getElementById('debitNet').textContent = '0.00';
            document.getElementById('creditNet').textContent = totalNet.toFixed(2); // Credit for net salaries

            // Calculate totals
            const totalDebit = (totalSB + totalCotPP).toFixed(2);
            const totalCredit = (totalCotPP + totalCotSP + totalIR + totalNet).toFixed(2);
            document.getElementById('totalDebit').textContent = totalDebit;
            document.getElementById('totalCredit').textContent = totalCredit;

            // Highlight if not balanced (optional visual cue)
            if (totalDebit !== totalCredit) {
                document.getElementById('totalDebit').style.color = 'red';
                document.getElementById('totalCredit').style.color = 'red';
            } else {
                document.getElementById('totalDebit').style.color = '';
                document.getElementById('totalCredit').style.color = '';
            }
        } else {
            document.getElementById('modalCompanyName').textContent = 'No Company Selected';
            document.getElementById('debitSB').textContent = '0.00';
            document.getElementById('creditSB').textContent = '0.00';
            document.getElementById('debitCotPP').textContent = '0.00';
            document.getElementById('creditCotPP').textContent = '0.00';
            document.getElementById('debitCotPPSP').textContent = '0.00';
            document.getElementById('creditCotPPSP').textContent = '0.00';
            document.getElementById('debitIR').textContent = '0.00';
            document.getElementById('creditIR').textContent = '0.00';
            document.getElementById('debitNet').textContent = '0.00';
            document.getElementById('creditNet').textContent = '0.00';
            document.getElementById('totalDebit').textContent = '0.00';
            document.getElementById('totalCredit').textContent = '0.00';
        }

        modal.classList.toggle('hidden');
    }

    // Close Accounting Sheet Modal
    function closeAccountingSheet() {
        document.getElementById('accountingSheetModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('accountingSheetModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeAccountingSheet();
        }
    });
    
    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Add stagger animation to cards
        const cards = document.querySelectorAll('.company-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
@endsection