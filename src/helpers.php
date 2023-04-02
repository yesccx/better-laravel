<?php

declare(strict_types = 1);

use Illuminate\Contracts\Support\Arrayable;

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
