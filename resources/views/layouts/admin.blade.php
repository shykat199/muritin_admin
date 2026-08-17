<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · Muritin Admin</title>
    <link rel="stylesheet" href="{{ asset('build/assets/fonts-C9MNnjVw.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-C26XgFTE.css') }}">
</head>
<body class="bg-gray-100 text-gray-900 antialiased">
    <div class="flex min-h-screen">
        <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-black/50 md:hidden"></div>

        <aside id="sidebar"
               class="fixed inset-y-0 left-0 z-40 w-64 shrink-0 -translate-x-full transform bg-gray-900 text-gray-200 transition-transform duration-200 ease-in-out md:static md:translate-x-0">
            <div class="flex items-center justify-between px-6 py-5 text-lg font-semibold text-white border-b border-gray-800">
                Muritin Admin
                <button id="sidebar-close" class="rounded-lg p-1 text-gray-400 hover:bg-gray-800 hover:text-white md:hidden" aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="px-3 py-4 space-y-1">
                <a href="{{ route('dashboard') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('categories.index') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('categories.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                    Categories
                </a>
                <a href="{{ route('audios.index') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('audios.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                    Audio
                </a>
            </nav>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex items-center justify-between gap-3 bg-white px-4 py-4 shadow-sm sm:px-6">
                <div class="flex min-w-0 items-center gap-3">
                    <button id="sidebar-open" class="shrink-0 rounded-lg p-2 text-gray-600 hover:bg-gray-100 md:hidden" aria-label="Open menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="truncate text-lg font-semibold sm:text-xl">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex shrink-0 items-center gap-2 sm:gap-4">
                    <span class="hidden text-sm text-gray-500 sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                            Log out
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">
                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm font-medium text-green-800 border border-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-800 border border-red-200">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        (function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openBtn = document.getElementById('sidebar-open');
            const closeBtn = document.getElementById('sidebar-close');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }

            openBtn.addEventListener('click', openSidebar);
            closeBtn.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);
        })();
    </script>
</body>
</html>
