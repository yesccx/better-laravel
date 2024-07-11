<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Foundation;

use Yesccx\BetterLaravel\Traits\InstanceMake;

abstract class Environment
{
    use InstanceMake;

    public const DEFAULT_ENVIRONMENT_KEY = 'CLOUDLADDER_DEPLOY_ENV';

    /**
     * @param string|int $environmentKey
     * @param string|int $environmentValue
     */
    public function __construct(
        protected string|int $environmentKey,
        protected string|int $environmentValue
    ) {
        if (empty($environmentKey)) {
            $this->environmentKey = config('better-laravel.runtime.environment_key', self::DEFAULT_ENVIRONMENT_KEY);
        }
    }

    /**
     * 验证为当前环境
     *
     * @return bool
     */
    public function verified(): bool
    {
        return $this->getEnvironment() === $this->environmentValue;
    }

    /**
     * 验证为非当前环境
     *
     * @return bool
     */
    public function notVerified(): bool
    {
        return !$this->verified();
    }

    /**
     * 为当前环境时做一些处理
     *
     * @param callable $handler
     * @param mixed $default
     *
     * @return mixed
     */
    public function when(callable $handler, mixed $default = null): mixed
    {
        if ($this->verified()) {
            return $handler();
        }

        return value($default);
    }

    /**
     * 为非当前环境时做一些处理
     *
     * @param callable $handler
     * @param mixed $default
     *
     * @return mixed
     */
    public function whenNot(callable $handler, mixed $default = null): mixed
    {
        if ($this->notVerified()) {
            return $handler();
        }

        return value($default);
    }

    /**
     * 获取环境值
     *
     * @return string
     */
    public function getEnvironment(): string
    {
        return rescue(fn () => (string) env($this->environmentKey), '');
    }

    /**
     * 包装字符串
     *
     * @param string $value
     *
     * @return string
     */
    public function wrapStr(string $value): string
    {
        return match (true) {
            $this->notVerified() => $value,
            default              => sprintf('%s:%s', $this->environmentValue, $value)
        };
    }
}
