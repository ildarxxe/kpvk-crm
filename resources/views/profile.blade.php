@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-3 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            @if(auth()->id() === $user->id)
                <h1 class="text-2xl font-bold text-gray-900">Мой профиль</h1>
                <p class="text-sm text-gray-400 mt-1">Управление личными данными и настройками аккаунта</p>
            @else
                <h1 class="text-2xl font-bold text-gray-900">Профиль пользователя</h1>
                <p class="text-sm text-gray-400 mt-1">Информация о сотруднике</p>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-1 space-y-4">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden text-center p-7">
                    <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>

                    <h2 class="text-base font-semibold text-gray-900 leading-snug">{{ $user->name }}</h2>
                    <span class="inline-block mt-2 text-xs text-indigo-600 font-medium bg-indigo-50 px-3 py-1 rounded-full">
                        {{ $user->role->display_name }}
                    </span>

                    <div class="mt-6 pt-5 border-t border-gray-100">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-xs text-gray-400">Дата регистрации</span>
                            <span class="text-sm text-gray-700">{{ $user->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->id === $user->id)
                    <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500 rounded-lg text-white shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04m14.562 0c.078.446.108.949.108 1.484 0 4.673-2.676 8.755-6.607 10.834a10.954 10.954 0 01-6.607-10.834c0-.535.03-1.038.108-1.484M12 7V3m0 0L8 7m4-4l4 4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-emerald-900">Аккаунт защищен</p>
                                <p class="text-xs text-emerald-600 mt-0.5">Ваши данные хранятся в безопасности</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-900">Персональные данные</h3>
                        @if(auth()->user()->id === $user->id)
                            <button onclick="openEditModal()" class="text-xs text-indigo-600 font-medium hover:text-indigo-800 transition-colors">Редактировать</button>
                        @else
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        @endif
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">ФИО</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400 mb-1">E-mail</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $user->email }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400 mb-1">Номер кабинета</p>
                            @if($user->cabinet_number)
                                <p class="text-sm font-semibold text-gray-900">Кабинет №{{ $user->cabinet_number }}</p>
                            @else
                                <p class="text-sm text-gray-400 italic">Не указан</p>
                            @endif
                        </div>

                        <div>
                            <p class="text-xs text-gray-400 mb-1">Номер телефона</p>
                            @if(isset($user->phone) && $user->phone)
                                <p class="text-sm font-semibold text-gray-900">{{ $user->phone }}</p>
                            @else
                                <p class="text-sm text-rose-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    Отсутствует
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                @if(auth()->user()->id === $user->id)
                    <div id="editProfileModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-900/50 transition-opacity" onclick="closeEditModal()"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                        <h3 class="text-base font-semibold text-gray-900">Редактировать профиль</h3>
                                        <button type="button" onclick="closeEditModal()" class="text-gray-300 hover:text-gray-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        </button>
                                    </div>

                                    <div class="px-6 py-5 space-y-4">
                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1.5">ФИО</label>
                                            <input type="text" name="name" value="{{ $user->name }}" required
                                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                                                   placeholder="Иванов Иван Иванович">
                                        </div>

                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1.5">Номер телефона</label>
                                            <input type="text" name="phone" value="{{ $user->phone }}" required
                                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                                                   placeholder="+7 777 000 00 00">
                                        </div>

                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1.5">Номер кабинета</label>
                                            <input type="number" name="cabinet_number" value="{{ $user->cabinet_number }}"
                                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                                                   placeholder="301">
                                        </div>

                                        <div>
                                            <label class="block text-xs text-gray-400 mb-1.5">E-mail <span class="text-gray-300">(недоступно для редактирования)</span></label>
                                            <input type="text" value="{{ $user->email }}" disabled
                                                   class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-400 cursor-not-allowed outline-none">
                                        </div>
                                    </div>

                                    <div class="px-6 py-4 flex justify-end gap-2 border-t border-gray-100">
                                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Отмена</button>
                                        <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">Сохранить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        function openEditModal() {
                            document.getElementById('editProfileModal').classList.remove('hidden');
                            document.body.style.overflow = 'hidden';
                        }
                        function closeEditModal() {
                            document.getElementById('editProfileModal').classList.add('hidden');
                            document.body.style.overflow = 'auto';
                        }
                    </script>

                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-base font-semibold text-gray-900">Безопасность</h3>
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>

                        <div class="p-6">
                            <form action="{{route("changePassword")}}" method="POST" class="space-y-4 max-w-sm">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label for="password" class="block text-xs text-gray-500 mb-1.5">Текущий пароль</label>
                                    <input type="password" name="password" id="password"
                                           class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                                           placeholder="••••••••">
                                </div>

                                <div>
                                    <label for="new_password" class="block text-xs text-gray-500 mb-1.5">Новый пароль</label>
                                    <input type="password" name="new_password" id="new_password"
                                           class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                                           placeholder="••••••••">
                                </div>

                                <button type="submit" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-black transition-colors">
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
