<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \App\Http\Middleware\RequestAcceptJson::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $exception) {
            return $request->expectsJson();
        });
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 401);
        });
        $exceptions->render(function (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 422);
        });
        $exceptions->render(function (Throwable $exception) {
            $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : $exception->getCode() ?? 500;
            $message = $exception->getMessage() ?: 'Server Error';
            return response()->json(['error' => $message], $statusCode);
        });
    })->create();
