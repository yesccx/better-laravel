<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Http\Supports;

use Yesccx\BetterLaravel\Tools\TypeTransfrom;

/**
 * 请求方法宏扩展
 */
final class RequestMacro
{
    public function fetch()
    {
        /**
         * 获取类型转换后的请求数据
         *
         * @param string $attribute 字段
         * @param mixed $default 默认值
         * @param array $data 数据集
         *
         * @return mixed
         */
        return function (
            string $attributes,
            mixed $default = null,
            ?array $data = null
        ): mixed {
            /** @var Request $this */
            return current($this->fetchMany([$attributes => $default], $data));
        };
    }

    public function fetchMany()
    {
        /**
         * 批量获取类型转换后的请求数据
         *
         * @param array $attributes 字段集
         * @param array $data 数据集
         * @return array
         */
        return function (
            array $attributes,
            ?array $data = null
        ): array {
            $data ??= request()->all();

            return TypeTransfrom::instance()->transfromMany($attributes, $data);
        };
    }
}
