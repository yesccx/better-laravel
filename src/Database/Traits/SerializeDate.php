<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Database\Traits;

/**
 * 日期格式化
 */
trait SerializeDate
{
    /**
     * 为 array / JSON 序列化准备日期格式
     *
     * @param \DateTimeInterface $date
     *
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format(config('better-laravel.date_format'));
    }
}
