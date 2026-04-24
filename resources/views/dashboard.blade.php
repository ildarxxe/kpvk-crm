@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-10 gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Рабочий стол</h1>
                <p class="text-gray-400 mt-0.5 text-xs tracking-wide">Система управления заявками</p>
            </div>

            @if($user->role_id === 1)
                <a href="{{ route('tasks.viewCreate') }}"
                   class="inline-flex items-center px-4 py-2.5 text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm self-start sm:self-auto">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Создать заявку
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4">
                <div class="p-2.5 rounded-lg bg-indigo-50 text-indigo-500 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Ваша роль</p>
                    <p class="text-base font-bold text-gray-900 uppercase">{{ $user->role->display_name }}</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-200 flex items-center gap-4">
                <div class="p-2.5 rounded-lg bg-emerald-50 text-emerald-500 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Всего заявок</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tasksCount }}</p>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <p class="text-xs text-gray-400 mb-2">Фильтр по статусу</p>
            <div class="flex flex-wrap gap-2" id="statusFilters">
                <button onclick="filterTasks('status', 'all')" data-status-filter="all" class="filter-btn-status px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-gray-900 text-white">
                    Все статусы
                </button>
                <button onclick="filterTasks('status', 'pending')" data-status-filter="pending" class="filter-btn-status px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-gray-500 border border-gray-200 hover:border-gray-300">
                    Ожидают
                </button>
                <button onclick="filterTasks('status', 'in_progress')" data-status-filter="in_progress" class="filter-btn-status px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-gray-500 border border-gray-200 hover:border-gray-300">
                    В работе
                </button>
                <button onclick="filterTasks('status', 'completed')" data-status-filter="completed" class="filter-btn-status px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-gray-500 border border-gray-200 hover:border-gray-300">
                    Завершенные
                </button>
            </div>
        </div>

        <div class="mb-8">
            <p class="text-xs text-gray-400 mb-2">Фильтр по приоритету</p>
            <div class="flex flex-wrap gap-2" id="priorityFilters">
                <button onclick="filterTasks('priority', 'all')" data-priority-filter="all" class="filter-btn-priority px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-gray-900 text-white">
                    Любой
                </button>
                @foreach($priorities as $priority)
                    <button onclick="filterTasks('priority', '{{ $priority->id }}')" data-priority-filter="{{ $priority->id }}" class="filter-btn-priority px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-gray-500 border border-gray-200 hover:border-gray-300">
                        {{ $priority->display_name }}
                    </button>
                @endforeach
                <button onclick="filterTasks('priority', 'none')" data-priority-filter="none" class="filter-btn-priority px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-gray-500 border border-gray-200 hover:border-gray-300">
                    Не задан
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Список заявок</h2>
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Заявка</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Создатель / Исполнитель</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Приоритет</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Статус</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wide">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="tasksTableBody">
                    @forelse($tasks as $task)
                        <tr class="task-item hover:bg-gray-50 transition-colors"
                            data-status="{{ $task->status }}"
                            data-priority="{{ $task->priority_id ?? 'none' }}">
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $task->title }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-xs text-gray-600">
                                        <span class="text-gray-400 w-14">Автор:</span>
                                        <a href="/profile/{{$task->teacher_id}}" class="hover:text-indigo-600">{{ $task->teacher->name ?? 'Учитель' }}</a>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-600">
                                        <span class="text-gray-400 w-14">Админ:</span>
                                        @if($task->admin)
                                            <a href="/profile/{{$task->admin_id}}" class="font-semibold text-indigo-600 hover:text-indigo-800">{{ $task->admin->name }}</a>
                                        @else
                                            <span class="text-gray-300 italic">Не назначен</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($task->priority)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium
                                        @if($task->priority_id == 3) bg-rose-50 text-rose-600
                                        @elseif($task->priority_id == 2) bg-amber-50 text-amber-600
                                        @else bg-emerald-50 text-emerald-600 @endif">
                                        <span class="w-1.5 h-1.5 rounded-full
                                            @if($task->priority_id == 3) bg-rose-400 @elseif($task->priority_id == 2) bg-amber-400 @else bg-emerald-400 @endif"></span>
                                        {{ $task->priority->display_name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    @if($task->status === 'completed') bg-emerald-100 text-emerald-700
                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-700
                                    @elseif($task->status === 'declined') bg-rose-100 text-rose-700
                                    @else bg-amber-100 text-amber-700 @endif">
                                    {{ $task->display_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-1.5">
                                    <a href="/tasks/{{$task->id}}" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Детали">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    @if($userRole === "teacher" && $task->teacher_id === auth()->user()->id && $task->status === "pending")
                                        <button onclick="openConfirmationModal({{ $task->id }}, '{{ addslashes($task->title) }}')"  class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg style="width: 16px; height: 16px" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    @endif

                                    @if($userRole === 'deputy' && $task->status === 'pending')
                                        <button type="button" onclick="openApproveModal('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="px-2.5 py-1 bg-emerald-500 text-white rounded-md text-xs font-semibold hover:bg-emerald-600 transition-colors">Одобрить</button>
                                        <form action="{{ route('tasks.decline', $task->id) }}" method="POST" class="inline">@csrf @method('PATCH')<button type="submit" class="px-2.5 py-1 bg-rose-500 text-white rounded-md text-xs font-semibold hover:bg-rose-600 transition-colors">Отклонить</button></form>
                                    @endif

                                    @if($userRole === 'admin' && $task->status === 'in_progress')
                                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="inline">@csrf @method('PATCH')<button type="submit" class="px-2.5 py-1 bg-indigo-500 text-white rounded-md text-xs font-semibold hover:bg-indigo-600 transition-colors">Завершить</button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="noTasksRow"><td colspan="5" class="px-6 py-16 text-center text-sm text-gray-400">Заявок нет</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-gray-100" id="tasksMobileContainer">
                @foreach($tasks as $task)
                    <div class="task-item p-4"
                         data-status="{{ $task->status }}"
                         data-priority="{{ $task->priority_id ?? 'none' }}">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">{{ $task->title }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-400">#{{ $task->id }}</span>
                                    @if($task->priority)
                                        <span class="text-xs
                                            @if($task->priority_id == 3) text-rose-500 @elseif($task->priority_id == 2) text-amber-500 @else text-emerald-500 @endif">
                                            ● {{ $task->priority->display_name }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-300">Без приоритета</span>
                                    @endif
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                @if($task->status === 'completed') bg-emerald-100 text-emerald-700
                                @elseif($task->status === 'in_progress') bg-blue-100 text-blue-700
                                @elseif($task->status === 'declined') bg-rose-100 text-rose-700
                                @else bg-amber-100 text-amber-700 @endif">
                                {{ $task->display_name }}
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3 mb-3 space-y-1.5">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-400">Автор:</span>
                                <a href="/profile/{{$task->teacher_id}}" class="text-gray-700 font-medium">{{ $task->teacher->name ?? 'Учитель' }}</a>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-400">Админ:</span>
                                <span class="@if($task->admin) text-indigo-600 font-medium @else text-gray-300 italic @endif">
                                    @if($task->admin)
                                        <a href="/profile/{{$task->admin_id}}">{{ $task->admin->name }}</a>
                                    @else
                                        Не назначен
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="/tasks/{{$task->id}}" class="flex-1 bg-gray-100 text-center py-2 rounded-lg text-xs font-medium text-gray-600 hover:bg-gray-200 transition-colors">Детали</a>
                            @if($userRole === 'deputy' && $task->status === 'pending')
                                <button onclick="openApproveModal('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="flex-1 bg-emerald-500 text-white py-2 rounded-lg text-xs font-semibold hover:bg-emerald-600 transition-colors">Одобрить</button>
                            @endif
                            @if($userRole === 'admin' && $task->status === 'in_progress')
                                <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="flex-1">@csrf @method('PATCH')<button type="submit" class="w-full bg-indigo-500 text-white py-2 rounded-lg text-xs font-semibold hover:bg-indigo-600 transition-colors">Завершить</button></form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="confirmationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-gray-900/50" onclick="closeConfirmationModal()"></div>
            <div class="relative bg-white rounded-xl shadow-xl border border-gray-100 w-full max-w-md mx-auto">

                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Удаление заявки</h3>
                    <p id="deleteTaskTitle" class="text-xs text-gray-400 mt-1"></p>
                </div>

                <div class="px-6 py-5">
                    <p class="text-sm text-gray-600">
                        Вы уверены, что хотите удалить эту заявку? Это действие нельзя отменить.
                    </p>
                </div>

                <div class="px-6 py-4 flex justify-end gap-2 border-t border-gray-100">
                    <button onclick="closeConfirmationModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        Отмена
                    </button>

                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 text-sm font-semibold text-white bg-rose-500 rounded-lg hover:bg-rose-600 transition-colors">
                            Удалить
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="globalApproveModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
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
                                    <label class="relative flex items-center p-3.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors group">
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
        let currentStatusFilter = 'all';
        let currentPriorityFilter = 'all';

        function filterTasks(type, value) {
            if (type === 'status') currentStatusFilter = value;
            if (type === 'priority') currentPriorityFilter = value;

            const statusButtons = document.querySelectorAll('.filter-btn-status');
            statusButtons.forEach(btn => {
                if (btn.getAttribute('data-status-filter') === currentStatusFilter) {
                    btn.className = "filter-btn-status px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-gray-900 text-white";
                } else {
                    btn.className = "filter-btn-status px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-gray-500 border border-gray-200 hover:border-gray-300";
                }
            });

            const priorityButtons = document.querySelectorAll('.filter-btn-priority');
            priorityButtons.forEach(btn => {
                if (btn.getAttribute('data-priority-filter') === currentPriorityFilter) {
                    btn.className = "filter-btn-priority px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-gray-900 text-white";
                } else {
                    btn.className = "filter-btn-priority px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-gray-500 border border-gray-200 hover:border-gray-300";
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

        function openConfirmationModal(taskId, taskTitle) {
            const modal = document.getElementById('confirmationModal');
            const form = document.getElementById('deleteForm');
            const title = document.getElementById('deleteTaskTitle');

            form.action = `/tasks/${taskId}`;
            title.innerText = `Заявка #${taskId}: ${taskTitle}`;

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeConfirmationModal() {
            const modal = document.getElementById('confirmationModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection
