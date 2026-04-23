@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-10 px-4">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Экспорт данных</h1>
            <p class="text-sm text-gray-400 mt-1">Выгрузка отчётов в формате Excel</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="p-6 sm:p-8">
                <form action="{{route("generate")}}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label for="date_from" class="block text-xs text-gray-500">Дата начала</label>
                            <input type="date" name="date_from" id="date_from"
                                   lang="ru-RU"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-500/10 outline-none transition-colors appearance-none">
                        </div>

                        <div class="space-y-1.5">
                            <label for="date_to" class="block text-xs text-gray-500">Дата окончания</label>
                            <input type="date" name="date_to" id="date_to"
                                   lang="ru-RU"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-500/10 outline-none transition-colors appearance-none">
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-100 flex items-start gap-3">
                        <div class="p-1.5 bg-blue-500 rounded-md text-white shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Информация</p>
                            <p class="text-xs text-blue-600 mt-0.5 leading-relaxed">Если даты не выбраны, система выгрузит все заявки за весь период работы CRM. Экспорт будет сформирован в виде таблицы.</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span>Сформировать и скачать</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
