<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Database\Supports;

/**
 * 分页器扩展配置项
 */
final class PaginatorOptions
{
    /**
     * 配置项
     *
     * @return array
     */
    public static function data(): array
    {
        return [
            'max_per_page'    => 50,
            'fetch_all_field' => 'fetch_all',
            'fetch_all'       => 0,
            'per_page_field'  => 'per_page',
            'per_page'        => 15,
            'page_field'      => 'page',
            'page'            => 1,
        ];
    }

    /**
     * 初始化配置项
     *
     * @param array $data
     * @return array
     */
    public static function init(array $data = []): array
    {
        return array_merge(static::data(), $data);
    }
}
