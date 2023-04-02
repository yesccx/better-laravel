<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Rules;

/**
 * 固定电话验证
 */
final class LandlinePhoneRule extends BaseRule
{
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
        return preg_match('/^0\d{2,3}-\d{7,8}$/', $value);
    }
}
