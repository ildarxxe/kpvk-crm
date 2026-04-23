@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 pb-16">
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Назад к списку
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 sm:px-8 py-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="space-y-2 flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs text-gray-400">{{ $task->created_at->format('d.m.Y H:i') }}</span>

                            @if($task->priority)
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-xs font-medium
                                    @if($task->priority_id == 3) bg-rose-50 text-rose-600
                                    @elseif($task->priority_id == 2) bg-amber-50 text-amber-600
                                    @else bg-emerald-50 text-emerald-600 @endif">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        @if($task->priority_id == 3) bg-rose-400 @elseif($task->priority_id == 2) bg-amber-400 @else bg-emerald-400 @endif"></span>
                                    {{ $task->priority->display_name }}
                                </span>
                            @else
                                <span class="text-xs text-gray-300">Приоритет не задан</span>
                            @endif
                        </div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 leading-snug">
                            {{ $task->title }}
                        </h1>
                    </div>

                    <div class="shrink-0">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                            @if($task->status === 'completed') bg-emerald-50 text-emerald-700 border border-emerald-100
                            @elseif($task->status === 'in_progress') bg-blue-50 text-blue-700 border border-blue-100
                            @elseif($task->status === 'declined') bg-rose-50 text-rose-700 border border-rose-100
                            @else bg-amber-50 text-amber-700 border border-amber-100 @endif">
                            <span class="w-1.5 h-1.5 rounded-full
                                @if($task->status === 'completed') bg-emerald-500
                                @elseif($task->status === 'in_progress') bg-blue-500
                                @elseif($task->status === 'declined') bg-rose-500
                                @else bg-amber-500 @endif"></span>
                            {{ $task->display_name }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="px-6 sm:px-8 py-7 space-y-8">
                <section>
                    <p class="text-xs text-gray-400 mb-3">Суть обращения</p>
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $task->description }}
                        </p>
                    </div>
                </section>

                <section class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-xl border border-gray-200 flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-500 rounded-lg flex items-center justify-center font-bold text-base shrink-0">
                            {{ mb_strtoupper(mb_substr($task->teacher->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Инициатор</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $task->teacher->name }}</p>
                        </div>
                    </div>

                    @if($task->admin)
                        <div class="bg-white p-4 rounded-xl border border-gray-200 flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-lg flex items-center justify-center font-bold text-base shrink-0">
                                {{ mb_strtoupper(mb_substr($task->admin->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Исполнитель</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $task->admin->name }}</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-xl border border-dashed border-gray-200 flex items-center gap-3">
                            <div class="w-10 h-10 bg-white border border-gray-200 text-gray-300 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Исполнитель</p>
                                <p class="text-sm text-gray-400 italic">Специалист не назначен</p>
                            </div>
                        </div>
                    @endif
                </section>

                @if($task->files->count() > 0)
                    <section>
                        <p class="text-xs text-gray-400 mb-3">Материалы ({{ $task->files->count() }})</p>
                        <div class="space-y-2">
                            @foreach($task->files as $file)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition-colors">
                                    <div class="flex items-center gap-3 mb-3 sm:mb-0">
                                        <div class="w-9 h-9 bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400 shrink-0">
                                            @if(Str::endsWith($file->file_path, '.zip') || Str::endsWith($file->file_path, '.rar'))
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            @endif
                                        </div>
                                        <div class="overflow-hidden">
                                            <p class="text-sm font-medium text-gray-800 truncate max-w-[200px] sm:max-w-xs">{{ $file->original_name }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $file->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $file->file_path) }}" download
                                       class="w-full sm:w-auto text-center px-4 py-2 bg-gray-900 text-white text-xs font-medium rounded-lg hover:bg-indigo-600 transition-colors">
                                        Скачать
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <section class="pt-6 border-t border-gray-100">
                    @if($task->status === 'completed')
                        @if(!$task->review)
                            @if(auth()->id() === $task->teacher_id)
                                <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                                    <div class="flex items-center gap-3 mb-5">
                                        <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center text-white shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                        </div>
                                        <h3 class="text-base font-semibold text-gray-900">Оцените работу</h3>
                                    </div>

                                    <form action="/tasks/{{$task->id}}/rate" method="POST" class="space-y-4">
                                        @csrf
                                        <div class="flex items-center gap-1">
                                            @foreach(range(1, 5) as $i)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="rate" value="{{ $i }}" class="hidden" required onclick="updateStars({{ $i }})">
                                                    <svg id="star-{{ $i }}" class="w-9 h-9 text-gray-200 fill-current transition-colors" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div>
                                            <textarea required name="comment" rows="3" placeholder="Ваш отзыв о выполнении..."
                                                      class="w-full bg-white border border-gray-200 rounded-lg px-4 py-3 text-sm text-gray-700 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 outline-none transition-colors resize-none"></textarea>
                                        </div>

                                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
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
                                <div class="p-4 bg-emerald-50 rounded-lg border border-emerald-100 flex items-center gap-3">
                                    <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-emerald-900">Задача выполнена</p>
                                        <p class="text-xs text-emerald-600 mt-0.5">Ожидается отзыв инициатора</p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-gray-50 rounded-xl border border-gray-100 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-500">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900">Отзыв инициатора</h3>
                                    </div>
                                    <div class="flex gap-0.5">
                                        @foreach(range(1, 5) as $i)
                                            <svg class="w-4 h-4 {{ $i <= $task->review->rate ? 'text-amber-400' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-gray-100">
                                    <p class="text-sm text-gray-600 italic">
                                        {{ $task->review->comment ?? 'Пользователь не оставил текстового комментария.' }}
                                    </p>
                                </div>
                                <p class="text-xs text-gray-400 mt-3">{{ $task->review->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                        @endif
                    @endif
                </section>

                <section class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row flex-wrap gap-3">

                    @if($task->status === 'completed')
                        <div class="w-full p-4 bg-emerald-50 rounded-lg border border-emerald-100 flex items-center gap-3 text-emerald-800">
                            <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold">Задача выполнена</p>
                                <p class="text-xs text-emerald-600 mt-0.5">Работа по данной заявке успешно завершена специалистом.</p>
                                @if($task->completed_at)
                                    <p class="text-xs text-emerald-500 mt-1">{{ $task->completed_at->format('d.m.Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    @can('moderate', $task)
                        <button onclick="openApproveModal('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="flex-1 bg-emerald-500 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-emerald-600 transition-colors shadow-sm">
                            Одобрить и назначить
                        </button>

                        <button onclick="document.getElementById('decline-form').submit()" class="flex-1 bg-white text-rose-500 border border-rose-300 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-rose-50 transition-colors">
                            Отклонить
                        </button>
                        <form id="decline-form" action="{{ route('tasks.decline', $task->id) }}" method="POST" class="hidden">@csrf @method('PATCH')</form>
                    @endcan

                    @can('complete', $task)
                        <button onclick="document.getElementById('complete-form').submit()" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
                            Подтвердить выполнение
                        </button>
                        <form id="complete-form" action="{{ route('tasks.complete', $task->id) }}" method="POST" class="hidden">@csrf @method('PATCH')</form>
                    @endcan
                </section>
            </div>
        </div>
    </div>

    <div id="approveModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900/50 transition-opacity" onclick="closeApproveModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <form id="approveForm" method="POST">
                    @csrf @method('PATCH')
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h5 class="text-base font-semibold text-gray-900">Одобрение заявки</h5>
                            <p id="modalTaskTitle" class="text-xs text-gray-400 mt-0.5"></p>
                        </div>
                        <button type="button" onclick="closeApproveModal()" class="text-gray-300 hover:text-gray-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </button>
                    </div>

                    <div class="px-6 py-5 space-y-6 max-h-[70vh] overflow-y-auto">
                        <div>
                            <p class="text-xs text-gray-400 mb-3">Назначить админа</p>
                            <div class="space-y-2">
                                @foreach($admins as $admin)
                                    <label class="relative flex items-center p-3.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="admin_id" value="{{ $admin->id }}" class="peer h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-800">{{ $admin->name }}</span>
                                            <span class="block text-xs text-gray-400">Исполнитель</span>
                                        </div>
                                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-indigo-500 rounded-lg pointer-events-none transition-all"></div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-400 mb-3">Выбрать приоритет</p>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach($priorities as $priority)
                                    <label class="relative flex flex-col items-center justify-center p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors text-center">
                                        <input type="radio" name="priority_id" value="{{ $priority->id }}" class="peer absolute opacity-0" required>
                                        <div class="w-2 h-2 rounded-full mb-1.5
                                            @if($priority->id == 3) bg-rose-400 @elseif($priority->id == 2) bg-amber-400 @else bg-emerald-400 @endif"></div>
                                        <span class="text-xs font-medium text-gray-700">{{ $priority->display_name }}</span>
                                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-gray-800 rounded-lg pointer-events-none transition-all"></div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 flex justify-end gap-2 border-t border-gray-100">
                        <button type="button" onclick="closeApproveModal()" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Отмена</button>
                        <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">Одобрить</button>
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
            titleDisplay.innerText = taskTitle;

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
