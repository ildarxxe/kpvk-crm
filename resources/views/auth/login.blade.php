@extends('layouts.app')

@section('content')
    <div class="min-h-[80vh] flex flex-col justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm mx-auto w-full">
            <div class="text-center mb-7">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-indigo-600 rounded-xl mb-4">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Вход в систему</h2>
                <p class="mt-1 text-sm text-gray-400">Добро пожаловать в ChainCRM</p>
            </div>

            <div class="bg-white px-8 py-7 rounded-xl border border-gray-200">
                <form action="{{ route('loginPost') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs text-gray-500 mb-1.5">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                            placeholder="address@gmail.com"
                            required
                        >
                    </div>
                    <div>
                        <label for="password" class="block text-xs text-gray-500 mb-1.5">Пароль</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="current-password"
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                            placeholder="••••••••"
                            required
                        >
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 px-4 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm mt-1">
                        Войти в аккаунт
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
