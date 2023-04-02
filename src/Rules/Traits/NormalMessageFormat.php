<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Rules\Traits;

/**
 * 默认的规则验证失败消息
 */
trait NormalMessageFormat
{
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf(':attribute 不合法');
    }
}
