<?php

use App\Http\Middleware\CheckProfileMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->use([
            CheckProfileMiddleware::class,
            \App\Http\Middleware\SsoMiddleware::class,
        ]);
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $this->getErrorMessage($e)], $e->getStatusCode());
            }

            $message = match ($e->getStatusCode()) {
                400 => 'Некорректный запрос.',
                401 => 'Требуется авторизация.',
                403 => 'У вас недостаточно прав для этого действия.',
                404 => 'Запрашиваемая страница не найдена.',
                405 => 'Метод не поддерживается для этого маршрута.',
                419 => 'Срок действия страницы истек. Попробуйте еще раз.',
                429 => 'Слишком много запросов. Пожалуйста, подождите.',
                500 => 'Ошибка сервера. Мы уже работаем над исправлением.',
                503 => 'Сервис временно недоступен. Технические работы.',
                default => $e->getMessage() ?: 'Произошла непредвиденная ошибка.',
            };

            return back()->withErrors(['error' => $message])->withInput();
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            return null;
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Сессия истекла.'], 401);
            }
            return redirect()->route('login')->withErrors(['error' => 'Пожалуйста, войдите в систему.']);
        });
    })->create();
