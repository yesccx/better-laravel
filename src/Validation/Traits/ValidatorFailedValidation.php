<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Validation\Traits;

use Illuminate\Contracts\Validation\Validator;
use Yesccx\BetterLaravel\Exceptions\ValidationException;

/**
 * 验证器自定义异常类
 */
trait ValidatorFailedValidation
{
    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator->errors()->first());
    }
}
