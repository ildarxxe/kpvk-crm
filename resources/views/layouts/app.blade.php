<!DOCTYPE html>
<html lang="ru" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $brandPrimary = 'ChainCRM';
        $brandLocal = 'КПВК CRM';
        $brandDomain = 'crm.kpvk.edu.kz';
    @endphp
    <title>@yield('title', $brandPrimary . ' — ' . $brandLocal)</title>

    <meta name="description" content="@yield('meta_description', 'ChainCRM — внутренняя CRM-система колледжа КПВК: заявки, уведомления, контроль исполнения и поддержка.')">

    <meta name="keywords" content="@yield('meta_keywords', 'ChainCRM, КПВК CRM, kpvk crm, кпвк срм, crm kpvk')">

    <link rel="canonical" href="@yield('canonical', url()->current())">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="chainCRM">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:title" content="@yield('title', 'ChainCRM — КПВК CRM')">
    <meta property="og:description" content="@yield('meta_description', 'ChainCRM — внутренняя CRM-система колледжа КПВК')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', url('/favicon.ico'))">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'ChainCRM — КПВК CRM')">
    <meta name="twitter:description" content="@yield('meta_description', 'ChainCRM — внутренняя CRM-система колледжа КПВК')">
    <meta name="twitter:image" content="@yield('og_image', url('/favicon.ico'))">

    @yield('schema')
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
        <div class="flex justify-between h-14">
            <div class="flex items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                @endauth
                @guest
                    <a href="{{ route('public.home') }}" class="flex items-center">
                @endguest
                    <span class="text-base font-bold tracking-tight text-gray-900">Chain<span class="text-indigo-600">CRM</span></span>
                </a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-6">
                @auth
                    @php $unread = auth()->user()->notifications()->whereNull('read_at')->count(); @endphp
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Рабочий стол</a>
                    @if(auth()->user()->role->role === 'deputy')
                        <a href="/export" class="text-sm text-indigo-600 hover:text-indigo-800 transition-colors">Экспорт</a>
                    @endif
                    <a href="{{ route('notifications') }}" class="relative text-sm text-gray-500 hover:text-gray-900 transition-colors">
                        Уведомления
                        @if($unread > 0)
                            <span class="absolute -top-1.5 -right-4 min-w-[16px] h-4 px-1 bg-indigo-600 text-white text-[10px] font-semibold rounded-full flex items-center justify-center">{{ $unread }}</span>
                        @endif
                    </a>
                    <a href="{{ route('support') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Поддержка</a>
                    <a href="{{ route('profile') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Профиль</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-rose-500 hover:text-rose-700 transition-colors">Выход</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('public.about') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">О системе</a>
                    <a href="{{ route('public.help.what_is_chaincrm') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Что такое ChainCRM</a>
                    <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition-colors">Вход</a>
                @endguest
            </div>

            <div class="flex items-center sm:hidden">
                <button id="mobile-menu-button" class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors focus:outline-none">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden sm:hidden bg-white border-b border-gray-100">
        <div class="px-4 pt-2 pb-5 space-y-0.5">
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">Рабочий стол</a>

                @if(auth()->user()->role->role === 'deputy')
                    <a href="/export" class="block px-3 py-2.5 rounded-lg text-sm text-indigo-600 hover:bg-indigo-50 transition-colors">Экспорт отчётов</a>
                @endif

                <a href="{{ route('notifications') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <span>Уведомления</span>
                    @if($unread > 0)
                        <span class="min-w-[18px] h-[18px] px-1 bg-indigo-600 text-white text-[10px] font-semibold rounded-full flex items-center justify-center">{{ $unread }}</span>
                    @endif
                </a>
                <a href="{{ route('support') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">Поддержка</a>
                <a href="{{ route('profile') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">Профиль</a>
                <div class="pt-3 mt-2 border-t border-gray-100">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2.5 rounded-lg text-sm text-rose-500 hover:bg-rose-50 transition-colors">Выйти из системы</button>
                    </form>
                </div>
            @endauth

            @guest
                <a href="{{ route('public.about') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">О системе</a>
                <a href="{{ route('public.help.what_is_chaincrm') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">Что такое ChainCRM</a>
                <a href="{{ route('login') }}" class="block px-3 py-2.5 rounded-lg text-sm text-indigo-600 hover:bg-indigo-50 transition-colors">Вход</a>
            @endguest
        </div>
    </div>
</nav>

<div id="notification-container" class="fixed top-16 right-4 z-50 flex flex-col gap-2 w-full max-w-sm px-4 sm:px-0">
    @if(session('success'))
        <div class="notification-item animate-slide-in bg-white border-l-4 border-emerald-500 shadow-md rounded-lg p-4 flex items-start gap-3">
            <div class="shrink-0 text-emerald-500 mt-0.5">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900">Успешно</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="notification-item animate-slide-in bg-white border-l-4 border-rose-500 shadow-md rounded-lg p-4 flex items-start gap-3">
                <div class="shrink-0 text-rose-500 mt-0.5">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Ошибка</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $error }}</p>
                </div>
            </div>
        @endforeach
    @endif
</div>

<main class="flex-grow px-3 sm:px-6 lg:px-8">
    @yield('content')
</main>

<footer class="bg-white border-t border-gray-100 py-5">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-xs text-gray-400">&copy; {{ date('Y') }} ChainCRM. Все права защищены.</p>
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
