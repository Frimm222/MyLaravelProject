<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Админ-панель')</title>

    <!-- Tailwind CDN (для быстрого старта) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Настройки Tailwind (можно расширить по вкусу) -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Шрифты (опционально, но сильно улучшают вид) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-inter antialiased">

<!-- Header / Navbar -->
<header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50 shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo / Brand -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 font-bold text-xl text-indigo-600 dark:text-indigo-400">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                <span>Music gallery</span>
            </a>

            <!-- Навигация (можно расширить) -->
            <nav class="hidden md:flex items-center gap-8">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('users.index') }}"
                   class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition">
                    Пользователи
                </a>
                @endif
                <a href="#"
                   class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition">
                    Настройки
                </a>
                <a href="{{ route('favorites.index') }}"
                   class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition">
                    Избранные
                </a>
            </nav>

            <!-- Правая часть (пользователь, тема и т.д.) -->
            <div class="flex items-center gap-4">
                <!-- Переключатель темы (опционально) -->
                <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="sun" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        <path id="moon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <!-- Аватар пользователя или кнопка входа -->
                <div class="flex items-center gap-3">
                    @auth
                        <span class="hidden sm:inline text-sm text-gray-700 dark:text-gray-300">
                                {{ auth()->user()->name }}
                            </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition">
                                Выйти
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                            Войти
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Основной контент -->
<main class="min-h-[calc(100vh-136px)]">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 mt-auto">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
            <div>
                © {{ date('Y') }} <span class="font-medium text-gray-900 dark:text-white">Admin Panel</span>. Все права защищены.
            </div>
            <div class="flex gap-6">
                <a href="#" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Документация</a>
                <a href="#" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Поддержка</a>
                <a href="#" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">О проекте</a>
            </div>
        </div>
    </div>
</footer>

<!-- Переключатель тёмной темы -->
<script>
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;

    // Проверяем сохранённую тему или системные настройки
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
        document.getElementById('moon').classList.remove('hidden');
        document.getElementById('sun').classList.add('hidden');
    } else {
        html.classList.remove('dark');
        document.getElementById('sun').classList.remove('hidden');
        document.getElementById('moon').classList.add('hidden');
    }

    themeToggle.addEventListener('click', () => {
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.theme = 'light';
            document.getElementById('sun').classList.remove('hidden');
            document.getElementById('moon').classList.add('hidden');
        } else {
            html.classList.add('dark');
            localStorage.theme = 'dark';
            document.getElementById('moon').classList.remove('hidden');
            document.getElementById('sun').classList.add('hidden');
        }
    });
</script>

@stack('scripts')

</body>
</html>
