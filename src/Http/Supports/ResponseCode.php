<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Http\Supports;

/**
 * http响应码
 */
final class ResponseCode
{
    /**
     * 成功响应信息
     */
    public const SUCCESS_MESSAGE = '操作成功';

    /**
     * 失败响应信息
     */
    public const ERROR_MESSAGE = '操作失败';

    /**
     * 成功响应码
     */
    public const SUCCESS_CODE = 200;

    /**
     * 失败响应码
     */
    public const ERROR_CODE = 400403;
}
