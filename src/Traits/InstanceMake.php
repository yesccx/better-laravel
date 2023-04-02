<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Traits;

use Illuminate\Support\Facades\App;

/**
 * 快速构建类的实例
 */
trait InstanceMake
{
    /**
     * Make Class
     *
     * 非单例/支持构建函数传参/不支持构造函数依赖注入
     *
     * @param array $parameters
     *
     * @return static
     */
    public static function make(...$parameters): static
    {
        return new static(...$parameters);
    }

    /**
     * Resolve Class
     *
     * 非单例/不支持构建函数传参/支持构造函数依赖注入
     *
     * @return static
     */
    public static function resolve(): static
    {
        return App::make(static::class);
    }

    /**
     * Instance Class
     *
     * 单例/不支持构建函数传参/支持构造函数依赖注入
     *
     * @param bool $force 强制重新初始化
     *
     * @return static
     */
    public static function instance(bool $force = false): static
    {
        if ($force) {
            App::singleton(static::class);
        } else {
            App::singletonIf(static::class);
        }

        return static::resolve();
    }
}
