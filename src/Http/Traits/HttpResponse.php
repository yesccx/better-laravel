<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Http\Traits;

use Illuminate\Http\JsonResponse;
use Yesccx\BetterLaravel\Contracts\HttpResponderContract;

/**
 * Http响应
 */
trait HttpResponse
{
    /**
     * 响应成功信息
     *
     * @param mixed $message 响应信息
     * @param mixed $data 响应数据
     * @param mixed $code 响应码
     * @param array $headers 响应头
     * @param int $options
     *
     * @return JsonResponse
     */
    public function responseSuccess(
        mixed $message = null,
        mixed $data = [],
        mixed $code = null,
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        return app(HttpResponderContract::class)->responseSuccess($message, $data, $code, $headers, $options);
    }

    /**
     * 响应失败信息
     *
     * @param mixed $message 响应信息
     * @param mixed $code 响应码
     * @param mixed $data 响应数据
     * @param array $headers 响应头
     * @param int $options
     *
     * @return JsonResponse
     */
    public function responseError(
        mixed $message = null,
        mixed $code = null,
        mixed $data = [],
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        return app(HttpResponderContract::class)->responseError($message, $code, $data, $headers, $options);
    }

    /**
     * 响应数据信息
     *
     * @param mixed $data 响应数据
     * @param string|bool $resource 是否使用资源类
     * @param mixed $message 响应信息
     * @param bool $isCollection 是否按集合处理，默认根据响应数据类型判断
     * @param mixed $code 响应码
     * @param array $headers 响应头
     * @param int $options
     *
     * @return JsonResponse
     */
    public function responseData(
        mixed $data = [],
        string|bool $resource = false,
        mixed $message = null,
        bool $isCollection = false,
        mixed $code = null,
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        return app(HttpResponderContract::class)->responseData($data, $resource, $message, $isCollection, $code, $headers, $options);
    }
}
