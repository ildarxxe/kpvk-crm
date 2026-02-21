@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-4 px-4 pb-12">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-indigo-600 transition-colors group">
                <div class="p-2 bg-white rounded-lg shadow-sm border border-gray-100 mr-3 group-hover:border-indigo-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                НАЗАД К СПИСКУ
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 sm:p-10 border-b border-gray-50 bg-gradient-to-r from-gray-50/50 to-transparent">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2 py-0.5 bg-gray-900 text-white text-[10px] font-black rounded-md tracking-wider uppercase">ID #{{ $task->id }}</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $task->created_at->format('d.m.Y H:i') }}</span>

                            <!-- ПРИОРИТЕТ -->
                            @if($task->priority)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider
                                    @if($task->priority_id == 3) bg-rose-50 text-rose-600 @elseif($task->priority_id == 2) bg-amber-50 text-amber-600 @else bg-emerald-50 text-emerald-600 @endif">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                        @if($task->priority_id == 3) bg-rose-500 @elseif($task->priority_id == 2) bg-amber-500 @else bg-emerald-500 @endif"></span>
                                    {{ $task->priority->display_name }}
                                </span>
                            @else
                                <span class="text-[10px] font-bold text-gray-300 uppercase italic">Приоритет не задан</span>
                            @endif
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight">
                            {{ $task->title }}
                        </h1>
                    </div>

                    <div class="flex flex-shrink-0">
                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black tracking-widest uppercase shadow-sm
                        @if($task->status === 'completed') bg-emerald-50 text-emerald-600 border border-emerald-100
                        @elseif($task->status === 'in_progress') bg-blue-50 text-blue-600 border border-blue-100
                        @elseif($task->status === 'declined') bg-rose-50 text-rose-600 border border-rose-100
                        @else bg-amber-50 text-amber-600 border border-amber-100 @endif">
                        <span class="w-2 h-2 rounded-full mr-2
                            @if($task->status === 'completed') bg-emerald-500
                            @elseif($task->status === 'in_progress') bg-blue-500
                            @elseif($task->status === 'declined') bg-rose-500
                            @else bg-amber-500 @endif animate-pulse"></span>
                        {{ $task->display_name }}
                    </span>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-10 space-y-10">
                <section>
                    <h3 class="flex items-center text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">
                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        Суть обращения
                    </h3>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <p class="text-gray-700 leading-relaxed font-medium whitespace-pre-line">
                            {{ $task->description }}
                        </p>
                    </div>
                </section>

                <section class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 flex items-center shadow-sm">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-black text-lg mr-4">
                            {{ mb_strtoupper(mb_substr($task->teacher->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Инициатор</p>
                            <p class="text-sm font-black text-gray-900">{{ $task->teacher->name }}</p>
                        </div>
                    </div>

                    @if($task->admin)
                        <div class="bg-white p-5 rounded-2xl border border-gray-100 flex items-center shadow-sm">
                            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-black text-lg mr-4">
                                {{ mb_strtoupper(mb_substr($task->admin->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Исполнитель</p>
                                <p class="text-sm font-black text-gray-900">{{ $task->admin->name }}</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-5 rounded-2xl border border-dashed border-gray-200 flex items-center">
                            <div class="w-12 h-12 bg-gray-100 text-gray-400 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Исполнитель</p>
                                <p class="text-sm font-bold text-gray-400 italic">Специалист не назначен</p>
                            </div>
                        </div>
                    @endif
                </section>

                @if($task->files->count() > 0)
                    <section>
                        <h3 class="flex items-center text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">
                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            Материалы ({{ $task->files->count() }})
                        </h3>
                        <div class="grid grid-cols-1 gap-3">
                            @foreach($task->files as $file)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-white rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-md transition-all group">
                                    <div class="flex items-center space-x-4 mb-3 sm:mb-0">
                                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-indigo-500 group-hover:bg-indigo-50 transition-colors">
                                            @if(Str::endsWith($file->file_path, '.zip') || Str::endsWith($file->file_path, '.rar'))
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                            @else
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            @endif
                                        </div>
                                        <div class="overflow-hidden">
                                            <p class="text-sm font-bold text-gray-900 truncate max-w-[200px] sm:max-w-xs">{{ $file->original_name }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">Загружен {{ $file->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $file->file_path) }}" download
                                       class="w-full sm:w-auto text-center px-6 py-2.5 bg-gray-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-indigo-600 transition-all shadow-lg shadow-gray-100">
                                        Скачать
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <section class="pt-10 border-t border-gray-50">
                    @if($task->status === 'completed')
                        @if(!$task->review)
                            @if(auth()->id() === $task->teacher_id)
                                <div class="bg-indigo-50/50 rounded-[2rem] border border-indigo-100 p-6 sm:p-10">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-100 flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                        </div>
                                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Оцените работу</h3>
                                    </div>
 
                                    <form action="/tasks/{{$task->id}}/rate" method="POST" class="space-y-6">
                                        @csrf
                                        <div class="flex items-center justify-center sm:justify-start space-x-1 sm:space-x-2" x-data="{ hover: 0, rating: 0 }">
                                            @foreach(range(1, 5) as $i)
                                                <label class="cursor-pointer transition-transform hover:scale-110 active:scale-90">
                                                    <input type="radio" name="rate" value="{{ $i }}" class="hidden" required onclick="updateStars({{ $i }})">
                                                    <svg id="star-{{ $i }}" class="w-10 h-10 sm:w-12 sm:h-12 text-gray-200 fill-current transition-colors" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div>
                                            <textarea required name="comment" rows="3" placeholder="Ваш отзыв о выполнении..."
                                                      class="w-full bg-white border-2 border-indigo-100 rounded-2xl px-4 py-3 sm:px-5 sm:py-4 font-medium text-gray-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all outline-none resize-none text-sm sm:text-base"></textarea>
                                        </div>
 
                                        <button type="submit" class="w-full sm:w-auto bg-indigo-600 text-white px-8 py-4 sm:px-10 sm:py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all">
                                            Отправить отзыв
                                        </button>
                                    </form>
                                </div>

                                <script>
                                    function updateStars(rating) {
                                        for (let i = 1; i <= 5; i++) {
                                            const star = document.getElementById('star-' + i);
                                            if (i <= rating) {
                                                star.classList.remove('text-gray-200');
                                                star.classList.add('text-amber-400');
                                            } else {
                                                star.classList.remove('text-amber-400');
                                                star.classList.add('text-gray-200');
                                            }
                                        }
                                    }
                                </script>
                            @else
                                <div class="w-full p-6 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center">
                                    <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white mr-4 shadow-lg shadow-emerald-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-black text-sm uppercase tracking-tight text-emerald-900">Задача выполнена</p>
                                        <p class="text-xs text-emerald-600/80 font-bold italic uppercase">Ожидается отзыв инициатора</p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-gray-50 rounded-[2rem] border border-gray-100 p-8 sm:p-10">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        </div>
                                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Отзыв инициатора</h3>
                                    </div>
                                    <div class="flex space-x-1">
                                        @foreach(range(1, 5) as $i)
                                            <svg class="w-5 h-5 {{ $i <= $task->review->rate ? 'text-amber-400' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                                    <p class="text-gray-700 font-medium italic">
                                        {{ $task->review->comment ?? 'Пользователь не оставил текстового комментария.' }}
                                    </p>
                                </div>
                                <p class="text-[10px] mt-4 font-black uppercase tracking-widest text-gray-400">Оставлен: {{ $task->review->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                        @endif
                    @endif
                </section>

                <section class="pt-10 border-t border-gray-50 flex flex-col sm:flex-row flex-wrap gap-4">

                    @if($task->status === 'completed')
                        <div class="w-full p-6 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center text-emerald-800">
                            <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white mr-4 shadow-lg shadow-emerald-100 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-black text-sm uppercase tracking-tight">Задача выполнена</p>
                                <p class="text-xs opacity-80 font-medium">Работа по данной заявке успешно завершена специалистом.</p>
                                @if($task->completed_at)
                                    <p class="text-[10px] mt-1 font-black uppercase tracking-wider text-emerald-600/70">Дата завершения: {{ $task->completed_at->format('d.m.Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    @can('moderate', $task)
                        <button onclick="openApproveModal('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="flex-1 bg-emerald-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-emerald-600 shadow-xl shadow-emerald-100 transition-all active:scale-95">
                            Одобрить и назначить
                        </button>

                        <button onclick="document.getElementById('decline-form').submit()" class="flex-1 bg-white text-rose-500 border-2 border-rose-500 px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-rose-50 transition-all active:scale-95">
                            Отклонить
                        </button>
                        <form id="decline-form" action="{{ route('tasks.decline', $task->id) }}" method="POST" class="hidden">@csrf @method('PATCH')</form>
                    @endcan

                    @can('complete', $task)
                        <button onclick="document.getElementById('complete-form').submit()" class="w-full bg-indigo-600 text-white px-8 py-5 rounded-2xl font-black uppercase tracking-widest text-sm hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all active:scale-[0.98]">
                            Подтвердить выполнение
                        </button>
                        <form id="complete-form" action="{{ route('tasks.complete', $task->id) }}" method="POST" class="hidden">@csrf @method('PATCH')</form>
                    @endcan
                </section>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" onclick="closeApproveModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <form id="approveForm" method="POST">
                    @csrf @method('PATCH')
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h5 class="text-lg font-bold text-gray-900">Одобрение заявки</h5>
                            <p id="modalTaskTitle" class="text-xs text-gray-500 mt-0.5 font-medium"></p>
                        </div>
                        <button type="button" onclick="closeApproveModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </button>
                    </div>

                    <div class="px-6 py-6 space-y-6 max-h-[70vh] overflow-y-auto">
                        <div class="space-y-3">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Назначить админа</label>
                            <div class="space-y-2">
                                @foreach($admins as $admin)
                                    <label class="relative flex items-center p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-indigo-50 transition-all group">
                                        <input type="radio" name="admin_id" value="{{ $admin->id }}" class="peer h-5 w-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                        <div class="ml-4">
                                            <span class="block text-sm font-bold text-gray-900 group-hover:text-indigo-700">{{ $admin->name }}</span>
                                            <span class="block text-[9px] text-gray-400 font-bold uppercase">Исполнитель</span>
                                        </div>
                                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-indigo-500 rounded-xl pointer-events-none transition-all"></div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-3 pt-4 border-t border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Выбрать приоритет</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                @foreach($priorities as $priority)
                                    <label class="relative flex flex-col items-center justify-center p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition-all text-center">
                                        <input type="radio" name="priority_id" value="{{ $priority->id }}" class="peer absolute opacity-0" required>
                                        <div class="w-2 h-2 rounded-full mb-1
                                            @if($priority->id == 3) bg-rose-500 @elseif($priority->id == 2) bg-amber-500 @else bg-emerald-500 @endif"></div>
                                        <span class="text-xs font-bold text-gray-800">{{ $priority->display_name }}</span>
                                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-gray-900 rounded-xl pointer-events-none transition-all"></div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row justify-end gap-3 border-t border-gray-100">
                        <button type="button" onclick="closeApproveModal()" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50">Отмена</button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-md transition-all active:scale-95">Одобрить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openApproveModal(taskId, taskTitle) {
            const modal = document.getElementById('approveModal');
            const form = document.getElementById('approveForm');
            const titleDisplay = document.getElementById('modalTaskTitle');

            form.reset();
            form.action = `/tasks/${taskId}/approve`;
            titleDisplay.innerText = `Заявка #${taskId}: ${taskTitle}`;

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeApproveModal() {
            const modal = document.getElementById('approveModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('approveForm').addEventListener('submit', function(e) {
            const adminChecked = this.querySelector('input[name="admin_id"]:checked');
            const priorityChecked = this.querySelector('input[name="priority_id"]:checked');

            if (!adminChecked || !priorityChecked) {
                e.preventDefault();
                alert('Пожалуйста, выберите и администратора, и приоритет перед одобрением.');
            }
        });
    </script>
@endsection
