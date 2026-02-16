<!DOCTYPE html>
<html lang="ru" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM КПВК</title>
    <link rel="icon" href="https://kpvk.edu.kz/wp-content/uploads/2021/06/cropped-Aktualnye_Logotip-32x32.jpg" sizes="32x32">
    <link rel="icon" href="https://kpvk.edu.kz/wp-content/uploads/2021/06/cropped-Aktualnye_Logotip-192x192.jpg" sizes="192x192">
    <link rel="apple-touch-icon" href="https://kpvk.edu.kz/wp-content/uploads/2021/06/cropped-Aktualnye_Logotip-180x180.jpg">
    <meta name="msapplication-TileImage" content="https://kpvk.edu.kz/wp-content/uploads/2021/06/cropped-Aktualnye_Logotip-270x270.jpg">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in { animation: slideIn 0.3s ease-out forwards; }
    </style>
</head>
<body class="bg-gray-50 min-h-full flex flex-col font-sans antialiased text-gray-900">

<nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-200">
                        <span class="text-white font-black text-sm">C</span>
                    </div>
                    <span class="text-xl font-black tracking-tight text-gray-900 uppercase">CRM <span class="text-indigo-600">КПВК</span></span>
                </a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                @auth
                    <a href="/" class="text-sm font-bold text-gray-500 hover:text-indigo-600 transition-colors">Рабочий стол</a>
                    @if(auth()->user()->role->role === 'deputy')
                        <a href="/export" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Экспорт</a>
                    @endif

                    <a href="{{ route('profile') }}" class="text-sm font-bold text-gray-500 hover:text-indigo-600 transition-colors">Профиль</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-rose-500 hover:text-rose-700 transition-colors">Выход</button>
                    </form>
                @endauth
            </div>

            <div class="flex items-center sm:hidden">
                <button id="mobile-menu-button" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden sm:hidden bg-white border-b border-gray-100 animate-slide-in">
        <div class="px-4 pt-2 pb-6 space-y-1">
            @auth
                <a href="/" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Рабочий стол</a>

                @if(auth()->user()->role->role === 'deputy')
                    <a href="/export" class="block px-4 py-3 rounded-xl text-base font-bold text-indigo-600 hover:bg-indigo-50 transition-all">Экспорт отчетов</a>
                @endif

                <a href="{{ route('profile') }}" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Профиль</a>
                <div class="pt-4 mt-4 border-t border-gray-100">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-base font-black text-rose-500 hover:bg-rose-50 transition-all uppercase tracking-wider">Выйти из системы</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

<div id="notification-container" class="fixed top-20 right-4 z-50 flex flex-col space-y-3 w-full max-w-sm px-4 sm:px-0">
    @if(session('success'))
        <div class="notification-item animate-slide-in bg-white border-l-4 border-emerald-500 shadow-xl rounded-xl p-4 flex items-start">
            <div class="flex-shrink-0 text-emerald-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-3 pr-8">
                <p class="text-sm font-bold text-gray-900">Успешно</p>
                <p class="text-xs text-gray-500 mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="notification-item animate-slide-in bg-white border-l-4 border-rose-500 shadow-xl rounded-xl p-4 flex items-start">
                <div class="flex-shrink-0 text-rose-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-3 pr-8">
                    <p class="text-sm font-bold text-gray-900">Ошибка</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $error }}</p>
                </div>
            </div>
        @endforeach
    @endif
</div>

<main class="flex-grow px-4 sm:px-6 lg:px-8">
    @yield('content')
</main>

<footer class="bg-white border-t border-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">&copy; {{ date('Y') }} CRM КПВК. Все права защищены.</p>
    </div>
</footer>

<script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    btn?.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });

    document.addEventListener('DOMContentLoaded', () => {
        const notifications = document.querySelectorAll('.notification-item');
        notifications.forEach(el => {
            setTimeout(() => {
                el.style.transition = 'all 0.5s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateX(50px)';
                setTimeout(() => el.remove(), 500);
            }, 5000);
        });
    });
</script>
</body>
</html>
