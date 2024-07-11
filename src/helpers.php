<?php

declare(strict_types = 1);

use Illuminate\Contracts\Support\Arrayable;
use Yesccx\BetterLaravel\Tools\GrayEnvironment;
use Yesccx\BetterLaravel\Tools\ProdEnvironment;

if (!function_exists('dumps')) {
    /**
     * dump wrapper
     * PS: 自动对集合做toArray
     *
     * @param mixed $vars
     *
     * @return void
     */
    function dumps(mixed ...$vars): void
    {
        foreach ($vars as $var) {
            dump($var instanceof Arrayable ? $var->toArray() : $var);
        }
    }
}

if (!function_exists('dds')) {
    /**
     * dd wrapper
     * PS: 自动对集合做toArray
     *
     * @param mixed $vars
     *
     * @return void
     */
    function dds(mixed ...$vars): void
    {
        dumps(...$vars);
        exit(1);
    }
}

if (!function_exists('explode_str_array')) {
    /**
     * 分割字符串数组
     *
     * @param string $str
     * @param string $separator 分割符(默认,)
     *
     * @return array
     */
    function explode_str_array(string $str, string $separator = ','): array
    {
        return array_values(
            array_filter(
                array_map('trim', explode($separator, $str))
            )
        );
    }
}

if (!function_exists('gray_environment')) {
    /**
     * 获取灰度环境实例
     *
     * @return GrayEnvironment
     */
    function gray_environment(): GrayEnvironment
    {
        return GrayEnvironment::instance();
    }
}

if (!function_exists('is_gray_environment')) {
    /**
     * 判断为灰度环境
     *
     * @return bool
     */
    function is_gray_environment(): bool
    {
        return GrayEnvironment::instance()->verified();
    }
}

if (!function_exists('when_gray_environment')) {
    /**
     * 当为灰度环境时做一些处理
     *
     * @param callable $handler
     * @param mixed $default
     *
     * @return mixed
     */
    function when_gray_environment(callable $handler, mixed $default = null): mixed
    {
        return GrayEnvironment::instance()->when($handler, $default);
    }
}

if (!function_exists('when_not_gray_environment')) {
    /**
     * 当为非灰度环境时做一些处理
     *
     * @param callable $handler
     * @param mixed $default
     *
     * @return mixed
     */
    function when_not_gray_environment(callable $handler, mixed $default = null): mixed
    {
        return GrayEnvironment::instance()->whenNot($handler, $default);
    }
}

if (!function_exists('prod_environment')) {
    /**
     * 获取生产环境实例
     *
     * @return ProdEnvironment
     */
    function prod_environment(): ProdEnvironment
    {
        return ProdEnvironment::instance();
    }
}

if (!function_exists('is_prod_environment')) {
    /**
     * 判断为生产环境
     *
     * @return bool
     */
    function is_prod_environment(): bool
    {
        return ProdEnvironment::instance()->verified();
    }
}

if (!function_exists('when_prod_environment')) {
    /**
     * 当为生产环境时做一些处理
     *
     * @param callable $handler
     * @param mixed $default
     *
     * @return mixed
     */
    function when_prod_environment(callable $handler, mixed $default = null): mixed
    {
        return ProdEnvironment::instance()->when($handler, $default);
    }
}

if (!function_exists('when_not_prod_environment')) {
    /**
     * 当为非生产环境时做一些处理
     *
     * @param callable $handler
     * @param mixed $default
     *
     * @return mixed
     */
    function when_not_prod_environment(callable $handler, mixed $default = null): mixed
    {
        return ProdEnvironment::instance()->whenNot($handler, $default);
    }
}