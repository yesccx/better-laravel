<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Rules;

use Yesccx\BetterLaravel\Rules\BaseRule;

/**
 * 数组id集验证
 */
final class ArrayIdsRule extends BaseRule
{
    /**
     * @param bool $allowZero 值允许为0
     * @param bool $allowNegativeNumber 值允许为负数
     * @param bool $allowFloatNumber 值允许浮点数
     * @param bool $allowRepeat 值允许重复
     *
     * @return void
     */
    public function __construct(
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
        if (!is_array($value)) {
            return false;
        } elseif (empty($value)) {
            return true;
        } elseif ($this->allowRepeat && collect($value)->duplicatesStrict()->isNotEmpty()) {
            return false;
        }

        return collect($value)->every(
            fn ($item)                                     => match (true) {
                !is_numeric($item)                         => false,
                !$this->allowZero && empty($item)          => false,
                !$this->allowNegativeNumber && $item < 0   => false,
                !$this->allowFloatNumber && !is_int($item) => false,
                default                                    => true
            }
        );
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
