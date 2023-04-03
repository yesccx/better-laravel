<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Contracts;

use Illuminate\Http\JsonResponse;
use Yesccx\BetterLaravel\Http\Supports\ResponseCode;

interface HttpResponderContract
{
    /**
     * @param mixed $message 响应信息
     * @param mixed $code 响应码
     * @param mixed $data 响应数据
     *
     * @return JsonResponse
     */
    public function toResponse(mixed $message, mixed $code, mixed $data = []): JsonResponse;

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
    public function responseSuccess(mixed $message = ResponseCode::SUCCESS_MESSAGE, mixed $data = [], mixed $code = ResponseCode::SUCCESS_CODE, array $headers = [], int $options = 0): JsonResponse;

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
    public function responseError(mixed $message = ResponseCode::ERROR_MESSAGE, mixed $code = ResponseCode::ERROR_CODE, mixed $data = [], array $headers = [], int $options = 0): JsonResponse;

    /**
     * 响应异常信息
     *
     * @param \Throwable $e
     * @param array $options
     *
     * @return JsonResponse
     */
    public function responseException(\Throwable $e, array $options = []): JsonResponse;

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
    public function responseData(mixed $data = [], string|bool $resource = false, mixed $message = ResponseCode::SUCCESS_MESSAGE, bool $isCollection = false, mixed $code = ResponseCode::SUCCESS_CODE, array $headers = [], int $options = 0): JsonResponse;
}
