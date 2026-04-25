@extends('layouts.app')

@section('title', 'Что такое ChainCRM — помощь | CRM КПВК')
@section('meta_description', 'Что такое ChainCRM (КПВК CRM): внутренняя CRM-система заявок колледжа. Как работает система, для кого предназначена и как получить доступ: crm.kpvk.edu.kz.')
@section('meta_keywords', 'что такое ChainCRM, ChainCRM, КПВК CRM, CRM КПВК, kpvk crm, система заявок колледжа')

@section('content')
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-gray-900">Что такое ChainCRM</h1>
        <p class="mt-3 text-gray-600">
            <strong>ChainCRM</strong> — это <strong>система заявок колледжа</strong> и внутренняя <strong>CRM КПВК</strong>,
            созданная для упорядочивания задач, обращений и контроля исполнения внутри колледжа.
        </p>

        <h2 class="mt-8 text-xl font-semibold text-gray-900">Зачем нужна ChainCRM</h2>
        <div class="mt-3 space-y-2 text-gray-700">
            <p>Сокращает время на согласование и обработку обращений.</p>
            <p>Делает статусы выполнения прозрачными для всех участников процесса.</p>
            <p>Помогает фиксировать ответственность и историю по каждой заявке.</p>
        </div>

        <h2 class="mt-8 text-xl font-semibold text-gray-900">Как получить доступ</h2>
        <p class="mt-3 text-gray-700">
            Доступ к ChainCRM предоставляется сотрудникам колледжа. Для входа используется страница авторизации.
            В публичном доступе находятся только информационные страницы о системе.
        </p>

        <div class="mt-8">
            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-sm font-semibold text-white hover:bg-indigo-700">
                Перейти к входу
            </a>
        </div>

        <div class="mt-10 bg-gray-50 border border-gray-200 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-900">Ключевые слова</h2>
            <p class="text-sm text-gray-700 mt-1">
                ChainCRM, CRM КПВК, КПВК CRM, kpvk crm, кпвк срм, crm kpvk, система заявок колледжа.
            </p>
        </div>
    </div>
@endsection
