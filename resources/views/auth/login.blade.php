@extends('layouts.app')

@section('content')
    <div class="min-h-[80vh] flex flex-col justify-center py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto w-full">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-2xl shadow-xl shadow-indigo-100 mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Вход в систему</h2>
                <p class="mt-2 text-sm text-gray-500 font-medium tracking-wide">Добро пожаловать в CRM КПВК</p>
            </div>

            <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100">
                <form action="{{ route('loginPost') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none border"
                            placeholder="address@gmail.com"
                            required
                        >
                    </div>
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Пароль</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="current-password"
                            class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none border"
                            placeholder="••••••••"
                            required
                        >
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-4 px-4 rounded-xl hover:bg-indigo-700 transition-all font-bold shadow-lg shadow-indigo-100 active:scale-[0.98]">
                        Войти в аккаунт
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
