<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Exceptions;

use Yesccx\BetterLaravel\Exceptions\Traits\RenderHttpResponse;

/**
 * 接口 异常
 */
class ApiException extends \Exception implements \Throwable
{
    use RenderHttpResponse;
}
