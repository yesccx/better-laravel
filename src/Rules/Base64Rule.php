<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Rules;

/**
 * base64验证
 */
final class Base64Rule extends BaseRule
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
        try {
            return base64_encode(base64_decode($value, true)) === $value;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf(':attribute 不是有效的base64格式');
    }
}
