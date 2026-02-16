@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Мой профиль</h1>
            <p class="text-gray-500 mt-1">Управление личными данными и настройками аккаунта</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden text-center p-8">
                    <div class="relative inline-block mb-4">
                        <div class="w-32 h-32 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-4xl font-black shadow-xl shadow-indigo-100">
                            {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-gray-900 leading-tight">{{ $user->name }}</h2>
                    <p class="text-indigo-600 font-extrabold text-xs uppercase tracking-widest mt-2 px-3 py-1 bg-indigo-50 inline-block rounded-full">
                        {{ $user->role->display_name }}
                    </p>

                    <div class="mt-8 pt-8 border-t border-gray-50 flex flex-col gap-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400 font-bold uppercase text-[10px]">Дата регистрации</span>
                            <span class="text-gray-700 font-medium">{{ $user->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                </div>
                @if(auth()->user()->id === $user->id)
                    <div class="mt-6 bg-emerald-50 rounded-2xl p-5 border border-emerald-100">
                        <div class="flex items-center">
                            <div class="p-2 bg-emerald-500 rounded-lg text-white mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04m14.562 0c.078.446.108.949.108 1.484 0 4.673-2.676 8.755-6.607 10.834a10.954 10.954 0 01-6.607-10.834c0-.535.03-1.038.108-1.484M12 7V3m0 0L8 7m4-4l4 4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-emerald-900">Аккаунт защищен</p>
                                <p class="text-xs text-emerald-700">Ваши данные хранятся в безопасности</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Персональные данные</h3>
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>

                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">ФИО</label>
                            <p class="text-gray-900 font-semibold text-lg">{{ $user->name }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Номер кабинета</label>
                            @if($user->cabinet_number)
                                <p class="text-gray-900 font-semibold text-lg">Кабинет №{{ $user->cabinet_number }}</p>
                            @else
                                <p class="text-gray-400 italic text-sm">Не указан</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Номер телефона</label>
                            @if(isset($user->phone) && $user->phone)
                                <p class="text-gray-900 font-semibold text-lg">{{ $user->phone }}</p>
                            @else
                                <p class="text-rose-500 font-medium text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    Отсутствует
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                @if(auth()->user()->id === $user->id)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900">Безопасность</h3>
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>

                        <div class="p-8">
                            <form action="{{route("changePassword")}}" method="POST" class="space-y-4 max-w-md">
                                @csrf
                                @method('PUT')

                                <div class="group">
                                    <label for="password" class="block text-xs font-bold text-gray-500 uppercase mb-2 ml-1">Текущий пароль</label>
                                    <input type="password" name="password" id="password"
                                           class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                                           placeholder="••••••••">
                                </div>

                                <div class="group">
                                    <label for="new_password" class="block text-xs font-bold text-gray-500 uppercase mb-2 ml-1">Новый пароль</label>
                                    <input type="password" name="new_password" id="new_password"
                                           class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                                           placeholder="••••••••">
                                </div>

                                <button type="submit" class="mt-2 w-full sm:w-auto px-8 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition-all shadow-lg shadow-gray-200 active:scale-95">
                                    Обновить пароль
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
