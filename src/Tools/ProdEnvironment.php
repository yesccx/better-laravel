<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Tools;

use Yesccx\BetterLaravel\Foundation\Environment;
use Yesccx\BetterLaravel\Traits\InstanceMake;

class ProdEnvironment extends Environment
{
    use InstanceMake;

    public const DEFAULT_ENVIRONMENT_VALUE = 'prod';

    /**
     * @param string|int $environmentKey
     * @param string|int $environmentValue
     */
    public function __construct(string|int $environmentKey = '', string|int $environmentValue = '')
    {
        parent::__construct(
            $environmentKey ?: '',
            $environmentValue ?: config('better-laravel.runtime.prod_environment_value', self::DEFAULT_ENVIRONMENT_VALUE)
        );
    }
}
