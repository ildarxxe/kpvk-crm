@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-4 px-4 pb-12">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-indigo-600 transition-colors group">
                <div class="p-2 bg-white rounded-lg shadow-sm border border-gray-100 mr-3 group-hover:border-indigo-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                ОТМЕНИТЬ СОЗДАНИЕ
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 sm:p-10 border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Новая заявка</h1>
                <p class="text-sm text-gray-500 mt-2 font-medium">Заполните данные ниже, чтобы технические специалисты могли вам помочь.</p>
            </div>

            <form action="{{ route('tasks.create') }}" method="POST" enctype="multipart/form-data" class="p-8 sm:p-10 space-y-8">
                @csrf
                <div class="space-y-2">
                    <label for="title" class="flex items-center text-xs font-black text-gray-400 uppercase tracking-[0.2em] ml-1">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                        Краткое название
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="w-full bg-gray-50 border-gray-200 rounded-2xl px-6 py-4 text-gray-900 font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none border @error('title') border-rose-500 bg-rose-50 @enderror"
                           placeholder="Например: Не включается интерактивная доска">
                    @error('title')
                    <p class="mt-2 text-xs font-bold text-rose-500 flex items-center ml-1 uppercase tracking-tight">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="description" class="flex items-center text-xs font-black text-gray-400 uppercase tracking-[0.2em] ml-1">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                        Детали проблемы
                    </label>
                    <textarea name="description" id="description" rows="6"
                              class="w-full bg-gray-50 border-gray-200 rounded-2xl px-6 py-4 text-gray-900 font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none border resize-none @error('description') border-rose-500 bg-rose-50 @enderror"
                              placeholder="Опишите, что именно произошло, номер кабинета и другие важные подробности...">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-2 text-xs font-bold text-rose-500 flex items-center ml-1 uppercase tracking-tight">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="space-y-4">
                    <label class="flex items-center text-xs font-black text-gray-400 uppercase tracking-[0.2em] ml-1">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                        Прикрепить фото или документы (необязательно)
                    </label>

                    <div class="relative group">
                        <input type="file" name="attachments[]" id="file-upload" multiple
                               onchange="updateFileName(this)"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="p-8 border-2 border-dashed border-gray-200 rounded-3xl bg-gray-50 group-hover:bg-indigo-50/50 group-hover:border-indigo-200 transition-all text-center">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 text-indigo-500 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-black text-gray-900 uppercase tracking-wider" id="file-status">Нажмите для выбора файлов</p>
                            <p class="text-xs text-gray-400 mt-2 font-bold uppercase tracking-tighter">Несколько файлов упакуются в ZIP</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white px-8 py-5 rounded-2xl font-black uppercase tracking-[0.15em] text-sm hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all active:scale-[0.98]">
                        Отправить специалисту
                    </button>
                    <a href="{{ route('dashboard') }}" class="sm:w-auto text-center bg-white text-gray-400 px-8 py-5 rounded-2xl font-black uppercase tracking-[0.15em] text-xs border border-gray-100 hover:bg-gray-50 transition-all">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const status = document.getElementById('file-status');
            const count = input.files.length;
            if (count > 0) {
                status.innerText = `Выбрано файлов: ${count}`;
                status.classList.remove('text-gray-900');
                status.classList.add('text-indigo-600');
            } else {
                status.innerText = 'Нажмите для выбора файлов';
                status.classList.add('text-gray-900');
                status.classList.remove('text-indigo-600');
            }
        }
    </script>
@endsection
