@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-10 px-4 pb-16">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Поддержка</h1>
            <p class="text-sm text-gray-400 mt-1">У вас проблема, вопрос, или вы хотите предложить идеи? Напишите нам — мы ответим как можно скорее</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-7 py-6">
                <form action="{{ route('support.send') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label for="subject" class="block text-xs text-gray-500 mb-1.5">Тема</label>
                        <input type="text" name="subject" id="subject"
                               value="{{ old('subject') }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors"
                               placeholder="Кратко опишите суть проблемы"
                               required>
                        @error('subject')
                        <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-xs text-gray-500 mb-1.5">Сообщение</label>
                        <textarea name="message" id="message" rows="5"
                                  class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm text-gray-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors resize-none"
                                  placeholder="Опишите проблему подробно — что произошло, при каких условиях, что ожидали увидеть..."
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                        <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">
                            Прикрепить файл <span class="text-gray-300 font-normal">— необязательно</span>
                        </label>
                        <div class="relative">
                            <input multiple type="file" name="attachments[]" id="attachment"
                                   onchange="updateFileName(this)"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="p-5 border-2 border-dashed border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100/70 hover:border-gray-300 transition-colors text-center">
                                <div class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center mx-auto mb-2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-600" id="file-status">Нажмите для выбора файлов</p>
                                <p class="text-xs text-gray-400 mt-0.5">Скриншот, документ или архив</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-2.5 px-4 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">
                            Отправить обращение
                        </button>
                    </div>
                </form>
            </div>

            <div class="px-7 py-4 bg-gray-50 border-t border-gray-100 flex items-start gap-3">
                <div class="p-1.5 bg-blue-500 rounded-md text-white shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-xs text-gray-400 leading-relaxed">Обращения рассматриваются в рабочее время. Ответ придёт вам в <a href="{{route("notifications")}}" class="text-gray-600 font-medium">уведомления</a></p>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const status = document.getElementById('file-status');
            if (input.files.length > 0) {
                status.innerText = input.files[0].name;
                status.classList.remove('text-gray-600');
                status.classList.add('text-indigo-600');
            } else {
                status.innerText = 'Нажмите для выбора файла';
                status.classList.add('text-gray-600');
                status.classList.remove('text-indigo-600');
            }
        }
    </script>
@endsection
