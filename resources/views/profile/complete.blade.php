@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex flex-col justify-center py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl mx-auto w-full">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-xl shadow-indigo-100 mb-6 text-white transform rotate-3 hover:rotate-6 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Почти готово!</h2>
            <p class="mt-2 text-lg text-gray-500 font-medium">Осталось проверить и дополнить ваши данные</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-100 border border-gray-100 overflow-hidden">
            <div class="p-8 sm:p-10">
                <form action="{{ route('profile.complete.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="group">
                        <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">ФИО</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" 
                                value="{{ old('name', $user->name) }}"
                                class="w-full bg-gray-50 border-gray-100 rounded-xl pl-11 pr-4 py-3.5 text-sm font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none border"
                                placeholder="Иванов Иван Иванович"
                                required>
                        </div>
                        @error('name')
                            <p class="mt-2 text-xs font-semibold text-rose-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="group">
                        <label for="phone" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Телефон</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <input type="text" name="phone" id="phone" 
                                value="{{ old('phone', $user->phone) }}"
                                class="w-full bg-gray-50 border-gray-100 rounded-xl pl-11 pr-4 py-3.5 text-sm font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none border"
                                placeholder="8 777 123 45 67"
                                required>
                        </div>
                        @error('phone')
                            <p class="mt-2 text-xs font-semibold text-rose-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="group">
                        <label for="cabinet_number" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Номер кабинета</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m3-4h1m-1 4h1m-1 4h1m3-4h1m-1 4h1"></path>
                                </svg>
                            </div>
                            <input type="number" name="cabinet_number" id="cabinet_number" 
                                value="{{ old('cabinet_number', $user->cabinet_number) }}"
                                class="w-full bg-gray-50 border-gray-100 rounded-xl pl-11 pr-4 py-3.5 text-sm font-semibold text-gray-800 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none border"
                                placeholder="Например: 101">
                        </div>
                        <p class="mt-2 text-xs text-gray-400 font-medium pl-1">Оставьте пустым, если у вас нет кабинета</p>
                        @error('cabinet_number')
                            <p class="mt-2 text-xs font-semibold text-rose-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="pt-6 flex flex-col sm:flex-row gap-4">
                        <button type="submit" class="order-1 sm:order-2 flex-1 w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-100 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all active:scale-[0.98]">
                            Сохранить и продолжить
                        </button>
                    </div>
                </form>
            </div>
            <div class="px-8 py-4 bg-gray-50/50 border-t border-gray-100/50 text-center">
                <a href="{{ route('profile') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">
                    Вернуться в профиль
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
