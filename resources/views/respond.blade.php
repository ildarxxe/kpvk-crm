<!DOCTYPE html>
<html lang="ru" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ответ на обращение — ChainCRM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-full font-sans antialiased text-gray-900">

<div class="max-w-2xl mx-auto py-10 px-4 pb-16">
    <div class="mb-8">
        <span class="text-base font-bold text-gray-900">Chain<span class="text-indigo-600">CRM</span></span>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Ответ на обращение</h1>
        <p class="text-sm text-gray-400 mt-1">Просмотрите обращение и напишите ответ пользователю</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-5">
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs text-gray-400 mb-1">Тема</p>
            <p class="text-base font-semibold text-gray-900">{{ $support->topic }}</p>
        </div>

        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs text-gray-400 mb-2">Сообщение</p>
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $support->message }}</p>
        </div>

        <div class="px-6 py-3 bg-gray-50 flex items-center gap-2">
            <div class="w-7 h-7 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0">
                {{ mb_strtoupper(mb_substr($support->user->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-xs text-gray-400">Автор обращения</p>
                <p class="text-sm font-medium text-gray-800">{{ $support->user->name }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-5">
            <form action="{{ route('notifications.respond', $support->id) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="response" class="block text-xs text-gray-500 mb-1.5">Ответ</label>
                    <textarea name="response" id="response" rows="5"
                              class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm text-gray-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 outline-none transition-colors resize-none"
                              placeholder="Напишите ответ пользователю..."
                              required>{{ old('response') }}</textarea>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">
                    Отправить ответ
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
