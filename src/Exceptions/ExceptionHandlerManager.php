<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Yesccx\BetterLaravel\Contracts\HttpResponderContract;
use Yesccx\BetterLaravel\Traits\InstanceMake;

final class ExceptionHandlerManager
{
    /**
     * @param \Illuminate\Foundation\Exceptions\Handler $handler
     * @param array $immediateExceptions
     *
     * @return void
     */
    public static function register(\Illuminate\Foundation\Exceptions\Handler $handler, array $immediateExceptions = []): void
    {
        // 捕获路由missing异常
        $handler->renderable(
            fn (NotFoundHttpException | MethodNotAllowedHttpException $e, $request) => static::httpResponder()->responseError(
                match (true) {
                    // ModelNotFoundException类会被转换为NotFoundHttpException，因此需要额外处理
                    $e?->getPrevious() instanceof ModelNotFoundException => $e?->getPrevious()?->getMessage(),
                    default                                              => config('better-laravel.exception.missing_summary', '内容不存在')
                }
            )
        );

        // 捕获表单验证异常
        $handler->renderable(
            fn (ValidationException $e, $request) => static::httpResponder()->responseError(
                $e?->validator?->errors()?->first() ?? config('better-laravel.exception.ignored_summary', '系统错误')
            )
        );

        // 捕获不明确的其它异常
        $handler->renderable(
            fn (\Throwable $e, $request) => static::httpResponder()->responseException(
                $e,
                collect($immediateExceptions)->contains(fn ($class) => $e instanceof $class) ? ['ignore_tracks' => false] : []
            )
        );
    }

    /**
     * Resolve HttpResponder
     *
     * @return HttpResponderContract
     */
    protected static function httpResponder(): HttpResponderContract
    {
        app()->singletonIf(
            HttpResponderContract::class,
            config('better-laravel.singletons', [])[HttpResponderContract::class] ?? null
        );

        return app(HttpResponderContract::class);
    }
}
