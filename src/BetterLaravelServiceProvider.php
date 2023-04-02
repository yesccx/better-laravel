<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Yesccx\BetterLaravel\Console\InstallCommand;
use Yesccx\BetterLaravel\Console\MigrateToSqlCommand;
use Yesccx\BetterLaravel\Console\OptimizeAllCommand;
use Yesccx\BetterLaravel\Database\Supports\BuilderMacro;
use Yesccx\BetterLaravel\Http\Supports\RequestMacro;
use Yesccx\BetterLaravel\Tools\FileCollector;

class BetterLaravelServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array<array-key, string>
     */
    public $singletons = [
        RequestMacro::class,
        BuilderMacro::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerDependencies();

        $this->defineCarbonFormat();

        $this->registerCommands();

        $this->registerPublishing();

        $this->registerModuleRoutes();

        $this->extendMacro();
    }

    /**
     * 注册依赖管理
     *
     * @return void
     */
    protected function registerDependencies()
    {
        foreach (config('better-laravel.dependencies', []) as $contract => $target) {
            $this->app->singleton($contract, $target);
        }
    }

    /**
     * 定义Carbon默认格式
     *
     * @return void
     */
    protected function defineCarbonFormat(): void
    {
        Carbon::setLocale('zh');
        Carbon::serializeUsing(function (Carbon $data) {
            return $data->rawFormat(config('better-laravel.date_format'));
        });
    }

    /**
     * 注册自定义命令行脚本
     *
     * @return void
     */
    protected function registerCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
            MigrateToSqlCommand::class,
            OptimizeAllCommand::class,
        ]);
    }

    /**
     * 注册模块路由收集
     *
     * @return void
     */
    protected function registerModuleRoutes(): void
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        if (!($this->app instanceof CachesRoutes && $this->app->routesAreCached())) {
            Route::prefix('api')
                ->middleware('api')
                ->group(FileCollector::scan('routes/modules'));
        }
    }

    /**
     * 扩展宏
     *
     * @return void
     */
    protected function extendMacro(): void
    {
        $extends = [
            \Illuminate\Database\Eloquent\Builder::class => [
                BuilderMacro::class,
            ],
            \Illuminate\Database\Query\Builder::class => [
                BuilderMacro::class,
            ],
            \Illuminate\Http\Request::class => [
                RequestMacro::class,
            ],
        ];

        // macro缓存
        $instanceCached = [];

        collect($extends)->each(
            fn ($targetExtends, $target) => collect($targetExtends)->each(
                fn ($extend) => $target::mixin(
                    $instanceCached[$extend] ??= $this->app->make($extend)
                )
            )
        );

        unset($instanceCached);
    }

    /**
     * Setup the configuration.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/better-laravel.php',
            'better-laravel'
        );
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/better-laravel.php' => config_path('better-laravel.php'),
        ], 'better-laravel-config');

        $this->publishes([
            __DIR__ . '/../stubs/BetterLaravelProvider.stub' => app_path('Providers/BetterLaravelProvider.php'),
        ], 'better-laravel-provider');
    }
}
