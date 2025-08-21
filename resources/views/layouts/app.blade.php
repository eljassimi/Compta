<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .modal { display: none; }
        .modal.show { display: block; }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold">Accountant Pro</h1>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('dashboard') }}" class="border-indigo-500 text-gray-900 dark:text-gray-100 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Dashboard</a>
                        <a href="{{ route('companies.index') }}" class="text-gray-900 dark:text-gray-100 hover:text-indigo-500 dark:hover:text-indigo-400 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">Companies</a>
                        <a href="{{ route('settings') }}" class="text-gray-900 dark:text-gray-100 hover:text-indigo-500 dark:hover:text-indigo-400 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">Settings</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <button id="theme-toggle" class="p-2 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                    <a href="{{ route('logout') }}" class="ml-4 text-gray-900 dark:text-gray-100 hover:text-indigo-500 dark:hover:text-indigo-400">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </div>

    <!-- Modal Component -->
    <div id="modal" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <h3 id="modal-title" class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100"></h3>
                <div id="modal-content" class="mt-2"></div>
                <div class="mt-4">
                    <button id="modal-close" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Theme Toggle
        document.getElementById('theme-toggle').addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
        });

        // Modal Control
        function showModal(title, content) {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-content').innerHTML = content;
            document.getElementById('modal').classList.add('show');
        }
        document.getElementById('modal-close').addEventListener('click', () => {
            document.getElementById('modal').classList.remove('show');
        });
    </script>
</body>
</html>