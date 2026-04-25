@extends('layouts.app')

@section('title', 'ChainCRM — КПВК CRM | Система заявок колледжа')
@section('meta_description', 'ChainCRM — CRM КПВК (crm.kpvk.edu.kz): внутренняя система заявок колледжа для преподавателей, заместителей директора и администраторов. Учет, уведомления, контроль исполнения.')
@section('meta_keywords', 'ChainCRM, КПВК CRM, CRM КПВК, kpvk crm, кпвк срм, crm kpvk, система заявок колледжа')

@section('schema')
    <script type="application/ld+json">
        @verbatim
        {
            "@context": "https://schema.org",
            "@type": "WebApplication",
            "name": "ChainCRM",
            "alternateName": ["КПВК CRM", "kpvk crm"],
            "url": "https://crm.kpvk.edu.kz",
            "applicationCategory": "BusinessApplication"
        }
        @endverbatim
    </script>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-gray-900">ChainCRM — CRM КПВК для управления заявками колледжа</h1>
        <p class="mt-3 text-gray-600">
            <strong>ChainCRM</strong> (также известна как <strong>КПВК CRM</strong>) — внутренняя CRM-система колледжа КГКП «КПВК»,
            размещённая по адресу <strong>crm.kpvk.edu.kz</strong>. Она помогает преподавателям, заместителям директора и администраторам
            оформлять и контролировать исполнение заявок.
        </p>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-semibold text-gray-900">Заявки и контроль</h2>
                <p class="text-sm text-gray-600 mt-1">Единая система заявок колледжа с этапами согласования и статусами исполнения.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-semibold text-gray-900">Роли и ответственность</h2>
                <p class="text-sm text-gray-600 mt-1">Доступ по ролям: преподаватель, заместитель директора, администратор.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-semibold text-gray-900">Уведомления и история</h2>
                <p class="text-sm text-gray-600 mt-1">Уведомления, история изменений и прозрачный контроль выполнения задач.</p>
            </div>
        </div>

        <div class="mt-10 bg-indigo-50 border border-indigo-100 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-900">Важно про доступ и индексацию</h2>
            <p class="text-sm text-gray-700 mt-1">
                ChainCRM — закрытая внутренняя система. Эта страница — публичная SEO-страница о продукте.
                Рабочие разделы CRM, профили и данные пользователей не предназначены для индексации.
            </p>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('public.about') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-semibold text-gray-900 hover:bg-gray-50">
                О системе
            </a>
            <a href="{{ route('public.help.what_is_chaincrm') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-semibold text-gray-900 hover:bg-gray-50">
                Что такое ChainCRM
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-sm font-semibold text-white hover:bg-indigo-700">
                Вход в CRM
            </a>
        </div>
    </div>
@endsection
