@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-10 px-4 pb-16">
        <div class="flex items-end justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Уведомления</h1>
                <p class="text-sm text-gray-400 mt-1">Ответы службы поддержки на ваши обращения</p>
            </div>

            @if($notifications->isNotEmpty() && $notifications->whereNull('read_at')->isNotEmpty())
                <form action="{{ route('notifications.markAsRead') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                        Отметить все прочитанным
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="bg-white rounded-xl border border-gray-200 px-7 py-16 text-center">
                <p class="text-sm text-gray-400">Нет уведомлений</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($notifications as $notification)
                    <div class="bg-white rounded-xl border transition-colors
                        {{ is_null($notification->read_at) ? 'border-indigo-200 bg-indigo-50/30' : 'border-gray-200' }}">
                        <div class="px-5 py-4">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex items-center gap-2 min-w-0">
                                    @if(is_null($notification->read_at))
                                        <span class="w-2 h-2 rounded-full bg-indigo-500 shrink-0"></span>
                                    @endif
                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $notification->support->topic }}
                                    </p>
                                </div>
                                <span class="text-xs text-gray-400 shrink-0">{{ $notification->created_at->format('d.m.Y H:i') }}</span>
                            </div>

                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-100">
                                    <p class="text-xs text-gray-400 mb-1">Ваш вопрос</p>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $notification->support->message }}</p>
                                </div>

                                <div class="bg-white rounded-lg px-4 py-3 border border-indigo-100">
                                    <p class="text-xs text-indigo-400 mb-1">Ответ поддержки</p>
                                    <p class="text-sm text-gray-800 leading-relaxed">{{ $notification->response }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
