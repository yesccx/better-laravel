<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Rules;

use Yesccx\BetterLaravel\Rules\BaseRule;
use Illuminate\Support\Facades\Validator;

/**
 * 子表单验证
 */
final class SubRequestRule extends BaseRule
{
    /**
     * 错误信息
     *
     * @var string
     */
    protected string $errorMessage = '';

    /**
     * @param string $subRequest 子验证类
     *
     * @return void
     */
    public function __construct(
        protected string $subRequest
    ) {
    }

    /**
     * 确定验证规则是否通过
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $subRequestInstance = new $this->subRequest;

        $validator = Validator::make(
            (array) $value,
            $subRequestInstance->rules(),
            $subRequestInstance->messages(),
            $subRequestInstance->attributes()
        );

        return tap(
            !$validator->fails(),
            fn () => $this->fail($validator->errors()->first())
        );
    }

    /**
     * 错误
     *
     * @param string $message 错误信息
     *
     * @return bool
     */
    protected function fail(string $message): bool
    {
        $this->errorMessage = $message ?: '未知错误';

        return false;
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return ":attribute 校验失败({$this->errorMessage})";
    }
}
