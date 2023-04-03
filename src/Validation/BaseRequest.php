<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Validation;

use Illuminate\Foundation\Http\FormRequest;
use Yesccx\BetterLaravel\Validation\Traits\ValidatorDefaultAuthorize;
use Yesccx\BetterLaravel\Validation\Traits\ValidatorFetchValidated;
use Yesccx\BetterLaravel\Validation\Traits\ValidatorScenes;

/**
 * 表单验证基类
 *
 * @see \Yesccx\BetterLaravel\Http\Supports\RequestMacro
 * @method mixed fetch( string $attributes, mixed $default = null, ?array $data = null ) 获取类型转换后的请求数据
 * @method array fetchMany( array $attributes, ?array $data = null) 获取类型转换后的请求数据
 */
abstract class BaseRequest extends FormRequest
{
    use ValidatorDefaultAuthorize, ValidatorScenes, ValidatorFetchValidated;

    /**
     * 表示验证器是否应在第一个规则失败时停止。
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
}
