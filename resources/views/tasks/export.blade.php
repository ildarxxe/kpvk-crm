@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-4">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Экспорт данных</h1>
            <p class="text-gray-500 font-bold text-sm mt-1 uppercase tracking-widest">Выгрузка отчетов в формате Excel</p>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 sm:p-12">
                <form action="{{route("generate")}}" method="POST" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label for="date_from" class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Дата начала</label>
                            <div class="relative">
                                <input type="date" name="date_from" id="date_from"
                                       lang="ru-RU"
                                       class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-4 font-bold text-gray-900 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 transition-all outline-none appearance-none">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="date_to" class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Дата окончания</label>
                            <div class="relative">
                                <input type="date" name="date_to" id="date_to"
                                       lang="ru-RU"
                                       class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-4 font-bold text-gray-900 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 transition-all outline-none appearance-none">
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 flex items-start space-x-4">
                        <div class="p-2 bg-blue-500 rounded-lg text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-blue-900">Информация</p>
                            <p class="text-xs text-blue-700 leading-relaxed font-medium">Если даты не выбраны, система выгрузит все заявки за весь период работы CRM. Экспорт будет сформирован в виде таблицы.</p>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-indigo-600 text-white px-8 py-5 rounded-2xl font-black uppercase tracking-widest text-sm hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all active:scale-[0.98] flex items-center justify-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span>Сформировать и скачать</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
