@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 border border-gray-200 rounded-lg shadow-sm">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Регистрация</h2>

        <form>
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Ваше ФИО</label>
                <input autocomplete type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border p-2 w-full" placeholder="Иван Иванов" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Номер телефона</label>
                <input autocomplete type="text" name="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border p-2 w-full" placeholder="8 777 123 45 67" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Номер кабинета</label>
                <input autocomplete type="number" name="cabinet_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border p-2 w-full" min="1" placeholder="0" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Пароль</label>
                <input autocomplete type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border p-2 w-full" required>
                <p class="mt-1 text-xs text-gray-500">Минимум 8 символов</p>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition font-semibold">
                Зарегистрироваться
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
            <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Уже есть аккаунт? Войти
            </a>
        </div>
    </div>
@endsection