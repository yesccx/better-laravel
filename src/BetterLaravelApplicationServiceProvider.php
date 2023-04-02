<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
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

        $config = config('better-laravel.exception', []);

        /** @var \Illuminate\Foundation\Exceptions\Handler $exceptionHandler */
        $exceptionHandler = $this->app->make(ExceptionHandler::class);

        // 捕获路由missing
        $exceptionHandler->renderable(
            fn (NotFoundHttpException | MethodNotAllowedHttpException $e, $request) => app(HttpResponderContract::class)->responseError($config['summary_missing'] ?: '内容不存在')
        );

        // 捕获业务异常
        $exceptionHandler->renderable(
            fn (\Throwable $e, $request) => match (true) {
                !$config['cover_reason'] => app(HttpResponderContract::class)->responseException($e),
                default                  => app(HttpResponderContract::class)->responseError($config['summary_cover'] ?: '系统错误')
            }
        );
    }
}
