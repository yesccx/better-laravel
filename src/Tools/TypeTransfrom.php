<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Tools;

use Throwable;
use Yesccx\BetterLaravel\Traits\InstanceMake;

/**
 * 类型转换
 */
final class TypeTransfrom
{
    use InstanceMake;

    /**
     * 批量类型转换
     *
     * @param array $attributes 字段集
     * @param array $data 数据集
     * @return array
     */
    public function transfromMany(array $attributes, array $data): array
    {
        return collect($attributes)
            ->mapWithKeys(function ($default, $attribute) use ($data) {
                [$attribute, $default] = match (true) {
                    is_numeric($attribute) => [$default, null],
                    default                => [$attribute, $default]
                };

                [$field, $type] = array_pad(explode('/', (string) $attribute), 2, null);
                $field = (string) $field;

                return [
                    $field => $this->transfrom($data[$field] ?? null, (string) $type, $default),
                ];
            })
            ->filter(fn ($value, $key) => !in_array($key, ['', false, null]))
            ->toArray();
    }

    /**
     * 类型转换
     *
     * @param mixed $data 值
     * @param mixed $type 类型
     *                    - (a)array 数组
     *                    - (n)number 数值
     *                    - (i)int 整数
     *                    - (f)float 浮点
     *                    - (b)bool 布尔
     *                    - (s)string 字符串
     *                    - (j)json JSON
     * @param mixed $default 默认值
     *
     * @return mixed
     */
    public function transfrom(mixed $data, string $type, mixed $default = null): mixed
    {
        if (is_null($data) || empty($type)) {
            return $default;
        }

        try {
            return match (mb_strtolower($type)) {
                // 数组
                'a', 'array' => (array) $data,

                // 数值
                'n', 'number' => $data + 0,

                // 整数
                'i', 'int' => (int) $data,

                // 浮点
                'f', 'float' => (float) $data,

                // 布尔
                'b','bool' => (bool) $data,

                // 字符串
                's', 'string' => (string) $data,

                // JSON
                'j', 'json' => json_decode($data, true),

                default => $default
            };
        } catch (Throwable) {
            return $default;
        }
    }
}
