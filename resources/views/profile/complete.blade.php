@extends('layouts.app')

@section('content')
    <div class="min-h-[60vh] flex flex-col justify-center py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto w-full">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-11 h-11 bg-indigo-600 rounded-xl mb-4 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Почти готово!</h2>
                <p class="mt-1 text-sm text-gray-400">Осталось проверить и дополнить ваши данные</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-7 py-6">
                    <form action="{{ route('profile.complete.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="block text-xs text-gray-500 mb-1.5">ФИО</label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                                   placeholder="Иванов Иван Иванович"
                                   required>
                            @error('name')
                            <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-xs text-gray-500 mb-1.5">Телефон</label>
                            <input type="text" name="phone" id="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                                   placeholder="8 777 123 45 67"
                                   required>
                            @error('phone')
                            <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div>
                            <label for="cabinet_number" class="block text-xs text-gray-500 mb-1.5">Номер кабинета</label>
                            <input type="number" name="cabinet_number" id="cabinet_number"
                                   value="{{ old('cabinet_number', $user->cabinet_number) }}"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                                   placeholder="101">
                            <p class="mt-1.5 text-xs text-gray-400">Оставьте пустым, если у вас нет кабинета</p>
                            @error('cabinet_number')
                            <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full py-2.5 px-4 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">
                                Сохранить и продолжить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
