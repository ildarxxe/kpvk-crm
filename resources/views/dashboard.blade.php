@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Рабочий стол</h1>
                <p class="text-gray-500 mt-1 uppercase text-xs font-bold tracking-widest">Система управления заявками</p>
            </div>

            @if($user->role_id === 1)
                <a href="{{ route('tasks.viewCreate') }}"
                   class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Создать заявку
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 rounded-xl bg-indigo-50 text-indigo-600 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Ваша роль</p>
                    <p class="text-xl font-black text-gray-900 uppercase">{{ $user->role->display_name }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Всего заявок</p>
                    <p class="text-xl font-black text-gray-900">{{ $tasksCount }}</p>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Фильтр по статусу</label>
            <div class="flex flex-wrap gap-2" id="statusFilters">
                <button onclick="filterTasks('status', 'all')" data-status-filter="all" class="filter-btn-status px-4 py-2 rounded-xl text-xs font-bold transition-all bg-gray-900 text-white shadow-md">
                    Все статусы
                </button>
                <button onclick="filterTasks('status', 'pending')" data-status-filter="pending" class="filter-btn-status px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">
                    Ожидают
                </button>
                <button onclick="filterTasks('status', 'in_progress')" data-status-filter="in_progress" class="filter-btn-status px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">
                    В работе
                </button>
                <button onclick="filterTasks('status', 'completed')" data-status-filter="completed" class="filter-btn-status px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">
                    Завершенные
                </button>
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Фильтр по приоритету</label>
            <div class="flex flex-wrap gap-2" id="priorityFilters">
                <button onclick="filterTasks('priority', 'all')" data-priority-filter="all" class="filter-btn-priority px-4 py-2 rounded-xl text-xs font-bold transition-all bg-gray-900 text-white shadow-md">
                    Любой
                </button>
                @foreach($priorities as $priority)
                    <button onclick="filterTasks('priority', '{{ $priority->id }}')" data-priority-filter="{{ $priority->id }}" class="filter-btn-priority px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">
                        {{ $priority->display_name }}
                    </button>
                @endforeach
                <button onclick="filterTasks('priority', 'none')" data-priority-filter="none" class="filter-btn-priority px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">
                    Не задан
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-xl font-bold text-gray-900">Список заявок</h2>
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Заявка</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Создатель / Исполнитель</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Приоритет</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Статус</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="tasksTableBody">
                    @forelse($tasks as $task)
                        <tr class="task-item hover:bg-gray-50/80 transition-colors"
                            data-status="{{ $task->status }}"
                            data-priority="{{ $task->priority_id ?? 'none' }}">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $task->title }}</div>
                                <div class="text-[10px] text-gray-400 mt-1 uppercase font-medium">ID: #{{ $task->id }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center text-xs text-gray-600">
                                        <span class="w-16 font-bold text-gray-400 uppercase text-[9px]">Автор:</span>
                                        <a href="/profile/{{$task->teacher_id}}" class="font-medium hover:text-indigo-600">{{ $task->teacher->name ?? 'Учитель' }}</a>
                                    </div>
                                    <div class="flex items-center text-xs text-gray-600">
                                        <span class="w-16 font-bold text-gray-400 uppercase text-[9px]">Админ:</span>
                                        @if($task->admin)
                                            <a href="/profile/{{$task->admin_id}}" class="font-bold text-indigo-600 hover:text-indigo-800">{{ $task->admin->name }}</a>
                                        @else
                                            <span class="italic text-gray-400">Отсутствует</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($task->priority)
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider border
                                        @if($task->priority_id == 3) bg-rose-50 text-rose-600 border-rose-100
                                        @elseif($task->priority_id == 2) bg-amber-50 text-amber-600 border-amber-100
                                        @else bg-emerald-50 text-emerald-600 border-emerald-100 @endif">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                            @if($task->priority_id == 3) bg-rose-500 @elseif($task->priority_id == 2) bg-amber-500 @else bg-emerald-500 @endif"></span>
                                        {{ $task->priority->display_name }}
                                    </div>
                                @else
                                    <span class="text-[10px] font-bold text-gray-300 uppercase italic">Не задан</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black tracking-wide uppercase
                                    @if($task->status === 'completed') bg-emerald-100 text-emerald-800
                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($task->status === 'declined') bg-rose-100 text-rose-800
                                    @else bg-amber-100 text-amber-800 @endif">
                                    {{ $task->display_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="/tasks/{{$task->id}}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg" title="Детали">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    @if($userRole === 'deputy' && $task->status === 'pending')
                                        <button type="button" onclick="openApproveModal('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="bg-emerald-500 text-white px-3 py-1.5 rounded-lg font-bold text-[10px] uppercase shadow-sm hover:bg-emerald-600">Одобрить</button>
                                        <form action="{{ route('tasks.decline', $task->id) }}" method="POST" class="inline">@csrf @method('PATCH')<button type="submit" class="bg-rose-500 text-white px-3 py-1.5 rounded-lg font-bold text-[10px] uppercase shadow-sm hover:bg-rose-600">Отклонить</button></form>
                                    @endif

                                    @if($userRole === 'admin' && $task->status === 'in_progress')
                                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="inline">@csrf @method('PATCH')<button type="submit" class="bg-indigo-500 text-white px-3 py-1.5 rounded-lg font-bold text-[10px] uppercase hover:bg-indigo-600">Завершить</button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="noTasksRow"><td colspan="5" class="px-6 py-12 text-center text-gray-400 font-bold uppercase text-xs">Заявок нет</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-gray-100" id="tasksMobileContainer">
                @foreach($tasks as $task)
                    <div class="task-item p-5"
                         data-status="{{ $task->status }}"
                         data-priority="{{ $task->priority_id ?? 'none' }}">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">{{ $task->title }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] text-gray-400 uppercase font-bold">ID: #{{ $task->id }}</span>
                                    @if($task->priority)
                                        <span class="text-[9px] font-bold uppercase
                                            @if($task->priority_id == 3) text-rose-500 @elseif($task->priority_id == 2) text-amber-500 @else text-emerald-500 @endif">
                                            ● {{ $task->priority->display_name }}
                                        </span>
                                    @else
                                        <span class="text-[9px] font-bold text-gray-300 uppercase italic">Без приоритета</span>
                                    @endif
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black uppercase
                                @if($task->status === 'completed') bg-emerald-100 text-emerald-800
                                @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                @elseif($task->status === 'declined') bg-rose-100 text-rose-800
                                @else bg-amber-100 text-amber-800 @endif">
                                {{ $task->display_name }}
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-3 mb-4 space-y-2">
                            <div class="flex justify-between text-[11px]">
                                <span class="text-gray-400 font-bold uppercase text-[9px]">Автор:</span>
                                <a href="/profile/{{$task->teacher_id}}" class="text-gray-900 font-medium">{{ $task->teacher->name ?? 'Учитель' }}</a>
                            </div>
                            <div class="flex justify-between text-[11px]">
                                <span class="text-gray-400 font-bold uppercase text-[9px]">Админ:</span>
                                <span class="@if($task->admin) text-indigo-600 font-bold @else text-gray-400 italic @endif">
                                    @if($task->admin)
                                        <a href="/profile/{{$task->admin_id}}">{{ $task->admin->name }}</a>
                                    @else
                                        Отсутствует
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="/tasks/{{$task->id}}" class="flex-1 bg-gray-100 text-center py-2 rounded-lg text-xs font-bold text-gray-600">Детали</a>
                            @if($userRole === 'deputy' && $task->status === 'pending')
                                <button onclick="openApproveModal('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="flex-1 bg-emerald-500 text-white py-2 rounded-lg text-xs font-bold uppercase">Одобрить</button>
                            @endif
                            @if($userRole === 'admin' && $task->status === 'in_progress')
                                <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="flex-1">@csrf @method('PATCH')<button type="submit" class="w-full bg-indigo-500 text-white py-2 rounded-lg text-xs font-bold uppercase">Завершить</button></form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="globalApproveModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
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
        let currentStatusFilter = 'all';
        let currentPriorityFilter = 'all';

        function filterTasks(type, value) {
            if (type === 'status') currentStatusFilter = value;
            if (type === 'priority') currentPriorityFilter = value;

            const statusButtons = document.querySelectorAll('.filter-btn-status');
            statusButtons.forEach(btn => {
                if (btn.getAttribute('data-status-filter') === currentStatusFilter) {
                    btn.className = "filter-btn-status px-4 py-2 rounded-xl text-xs font-bold transition-all bg-gray-900 text-white shadow-md";
                } else {
                    btn.className = "filter-btn-status px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50";
                }
            });

            const priorityButtons = document.querySelectorAll('.filter-btn-priority');
            priorityButtons.forEach(btn => {
                if (btn.getAttribute('data-priority-filter') === currentPriorityFilter) {
                    btn.className = "filter-btn-priority px-4 py-2 rounded-xl text-xs font-bold transition-all bg-gray-900 text-white shadow-md";
                } else {
                    btn.className = "filter-btn-priority px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50";
                }
            });

            const tasks = document.querySelectorAll('.task-item');
            let visibleCount = 0;

            tasks.forEach(task => {
                const taskStatus = task.getAttribute('data-status');
                const taskPriority = task.getAttribute('data-priority');

                const matchesStatus = (currentStatusFilter === 'all' || taskStatus === currentStatusFilter);
                const matchesPriority = (currentPriorityFilter === 'all' || taskPriority === currentPriorityFilter);

                if (matchesStatus && matchesPriority) {
                    task.style.display = '';
                    visibleCount++;
                } else {
                    task.style.display = 'none';
                }
            });

            const noTasksRow = document.getElementById('noTasksRow');
            if (noTasksRow) {
                noTasksRow.style.display = (visibleCount === 0) ? '' : 'none';
            }
        }

        function openApproveModal(taskId, taskTitle) {
            const modal = document.getElementById('globalApproveModal');
            const form = document.getElementById('approveForm');
            const titleDisplay = document.getElementById('modalTaskTitle');

            form.reset();
            form.action = `/tasks/${taskId}/approve`;
            titleDisplay.innerText = `Заявка #${taskId}: ${taskTitle}`;

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeApproveModal() {
            const modal = document.getElementById('globalApproveModal');
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
