<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Exceptions;

use Yesccx\BetterLaravel\Exceptions\Traits\RenderHttpResponse;

/**
 * 表单验证 异常
 */
class ValidationException extends \Exception implements \Throwable
{
    use RenderHttpResponse;
}
