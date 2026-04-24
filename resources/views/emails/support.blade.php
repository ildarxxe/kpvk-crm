<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial; }
        .container { padding: 20px; }
        .block { margin-bottom: 15px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <h2>Новое сообщение в поддержку</h2>

    <div class="block">
        <span class="label">Пользователь:</span>
        <div>{{ $data['username'] }}</div>
    </div>

    <div class="block">
        <span class="label">Тема:</span>
        <div>{{ $data['subject'] }}</div>
    </div>

    <div class="block">
        <span class="label">Сообщение:</span>
        <div>{{ $data['message'] }}</div>
    </div>
    <div class="block">
        <a href="{{env("APP_URL")}}/respond/{{$data["token"]}}">
            Ответить
        </a>
    </div>
</div>
</body>
</html>
