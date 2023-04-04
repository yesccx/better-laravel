<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Yesccx\BetterLaravel\Contracts\HttpResponderContract;

class BetterLaravelApplicationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

        $this->registerExceptionHandler();
    }

    /**
     * 注册异常处理
     *
     * @return void
     */
    protected function registerExceptionHandler(): void
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        /** @var \Illuminate\Foundation\Exceptions\Handler $exceptionHandler */
        $exceptionHandler = $this->app->make(ExceptionHandler::class);

        /** @var \Yesccx\BetterLaravel\Http\Responder $httpResponser */
        $httpResponser = $this->app->make(HttpResponderContract::class);

        // 捕获路由missing异常
        $exceptionHandler->renderable(
            fn (NotFoundHttpException | MethodNotAllowedHttpException $e, $request) => $httpResponser->responseError(
                match (true) {
                    // ModelNotFoundException类会被转换为NotFoundHttpException，因此在需要额外处理
                    $e?->getPrevious() instanceof ModelNotFoundException => $e?->getPrevious()?->getMessage(),
                    default                                              => config('better-laravel.exception.missing_summary', '内容不存在')
                }
            )
        );

        // 捕获表单验证异常
        $exceptionHandler->renderable(
            fn (ValidationException $e, $request) => $httpResponser->responseError(
                $e?->validator?->errors()?->first() ?? config('better-laravel.exception.ignored_summary', '系统错误')
            )
        );

        // 捕获不明确的其它异常
        $exceptionHandler->renderable(
            fn (\Throwable $e, $request) => $httpResponser->responseException($e, [
                'ignore_tracks' => !collect($this->immediateExceptions())->contains(fn ($class) => $e instanceof $class),
            ])
        );
    }

    /**
     * 立即响应的异常，不经过判断处理
     *
     * @return array
     */
    protected function immediateExceptions(): array
    {
        return [];
    }
}
