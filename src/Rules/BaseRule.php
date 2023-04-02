<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Yesccx\BetterLaravel\Rules\Traits\NormalMessageFormat;

/**
 * 验证规则基类
 */
abstract class BaseRule implements Rule
{
    use NormalMessageFormat;
}
