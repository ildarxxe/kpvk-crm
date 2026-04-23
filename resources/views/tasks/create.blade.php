@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-8 px-3 sm:px-4 pb-16">
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Назад
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100">
                <h1 class="text-xl font-bold text-gray-900">Новая заявка</h1>
                <p class="text-sm text-gray-400 mt-1">Заполните данные ниже, чтобы технические специалисты могли вам помочь.</p>
            </div>

            <form action="{{ route('tasks.create') }}" method="POST" enctype="multipart/form-data" class="px-8 py-7 space-y-6">
                @csrf
                <div class="space-y-1.5">
                    <label for="title" class="block text-xs font-medium text-gray-500 ml-0.5">
                        Краткое название
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors @error('title') border-rose-400 bg-rose-50 @enderror"
                           placeholder="Например: Не включается интерактивная доска">
                    @error('title')
                    <p class="text-xs text-rose-500 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="description" class="block text-xs font-medium text-gray-500 ml-0.5">
                        Детали проблемы
                    </label>
                    <textarea name="description" id="description" rows="5"
                              class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors resize-none @error('description') border-rose-400 bg-rose-50 @enderror"
                              placeholder="Опишите, что именно произошло, номер кабинета и другие важные подробности...">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-xs text-rose-500 flex items-center gap-1 mt-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-medium text-gray-500 ml-0.5">
                        Прикрепить файлы <span class="text-gray-300 font-normal">— необязательно</span>
                    </label>

                    <div class="relative">
                        <input type="file" name="attachments[]" id="file-upload" multiple
                               onchange="updateFileName(this)"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="p-6 border-2 border-dashed border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100/70 hover:border-gray-300 transition-colors text-center">
                            <div class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center mx-auto mb-3 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-600" id="file-status">Нажмите для выбора файлов</p>
                            <p class="text-xs text-gray-400 mt-1">Несколько файлов упакуются в ZIP</p>
                        </div>
                    </div>
                </div>

                <div class="pt-2 flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
                        Отправить специалисту
                    </button>
                    <a href="{{ route('dashboard') }}" class="sm:w-auto text-center bg-white text-gray-500 px-6 py-2.5 rounded-lg text-sm font-medium border border-gray-200 hover:bg-gray-50 transition-colors">
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
                status.classList.remove('text-gray-600');
                status.classList.add('text-indigo-600');
            } else {
                status.innerText = 'Нажмите для выбора файлов';
                status.classList.add('text-gray-600');
                status.classList.remove('text-indigo-600');
            }
        }
    </script>
@endsection
