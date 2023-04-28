<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Rules;

use Yesccx\BetterLaravel\Rules\BaseRule;

/**
 * 字符串数组id集验证
 */
class StringArrayIdsRule extends BaseRule
{
    /**
     * @param string $separator 分隔符
     * @param bool $allowZero 值允许为0
     * @param bool $allowNegativeNumber 值允许为负数
     * @param bool $allowFloatNumber 值允许浮点数
     * @param bool $allowRepeat 值允许重复
     *
     * @return void
     */
    public function __construct(
        protected string $separator = ',',
        protected bool $allowZero = false,
        protected bool $allowNegativeNumber = false,
        protected bool $allowFloatNumber = false,
        protected bool $allowRepeat = false
    ) {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_string($value)) {
            return false;
        } elseif ($value === '') {
            return true;
        }

        try {
            $value = array_map(
                fn ($item) => trim($item) + 0,
                explode($this->separator, $value),
            );
        } catch (\Throwable) {
            return false;
        }

        return (new ArrayIdsRule(
            allowZero: $this->allowZero,
            allowNegativeNumber: $this->allowNegativeNumber,
            allowFloatNumber: $this->allowFloatNumber,
            allowRepeat: $this->allowRepeat
        ))->passes($attribute, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute 不是有效的格式.';
    }
}
