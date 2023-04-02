<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Exceptions;

use Yesccx\BetterLaravel\Exceptions\Traits\RenderHttpResponse;

/**
 * 服务层 异常
 */
class ServiceException extends \Exception implements \Throwable
{
    use RenderHttpResponse;
}
