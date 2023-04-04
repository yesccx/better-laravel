<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Contracts;

interface WithExceptionOptions
{
    /**
     * 异常配置项
     *
     * @return array
     */
    public function exceptionOptions(): array;
}
