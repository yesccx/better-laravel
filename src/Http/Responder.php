<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Yesccx\BetterLaravel\Contracts\HttpResponderContract;
use Yesccx\BetterLaravel\Contracts\WithExceptionOptions;
use Yesccx\BetterLaravel\Http\Supports\ResponseCode;
use Yesccx\BetterLaravel\Traits\InstanceMake;

/**
 * Http响应器
 */
class Responder implements HttpResponderContract
{
    use InstanceMake;

    /**
     * 响应
     *
     * @param mixed $message 响应信息
     * @param mixed $code 响应码
     * @param mixed $data 响应数据
     * @param array $headers 响应头
     * @param int $options
     *
     * @return JsonResponse
     */
    public function toResponse(
        mixed $message,
        mixed $code,
        mixed $data = [],
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        return new JsonResponse(
            data: [
                'message' => $message,
                'code'    => $code,
                'data'    => $data,
            ],
            headers: $headers,
            options: $options
        );
    }

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
        return $this->toResponse(
            $message ?? $this->resolveDefaultValue(ResponseCode::SUCCESS_MESSAGE),
            $code ?? $this->resolveDefaultValue(ResponseCode::SUCCESS_CODE),
            $data,
            $headers,
            $options
        );
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
        return $this->toResponse(
            $message ?? $this->resolveDefaultValue(ResponseCode::ERROR_MESSAGE),
            $code ?? $this->resolveDefaultValue(ResponseCode::ERROR_CODE),
            $data,
            $headers,
            $options
        );
    }

    /**
     * 响应异常信息
     *
     * @param \Throwable $e
     * @param array $options
     *
     * @return JsonResponse
     */
    public function responseException(\Throwable $e, array $options = []): JsonResponse
    {
        $exceptionOptions = match (true) {
            $e instanceof WithExceptionOptions => $e->exceptionOptions(),
            default                            => []
        };

        $options = array_merge(
            config('better-laravel.exception', []),
            $exceptionOptions,
            $options
        );

        return $this->responseError(
            message: match (true) {
                !$options['ignore_tracks'] => $e->getMessage(),
                default                    => $options['ignored_summary'] ?: '系统错误'
            },
            code: match (true) {
                (bool) $options['use_exception_code'] => $e->getCode() ?: null,
                default                               => null
            }
        );
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
        $data = match (true) {
            // 不额外处理
            false === $resource => $data,

            // 按集合、数组处理
            /** @var \Illuminate\Http\Resources\Json\JsonResource $resource */
            $isCollection || $data instanceof Collection => $resource::collection($data),

            // 按分页处理
            $data instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator,
            $data instanceof \Illuminate\Contracts\Pagination\Paginator => $data->setCollection(
                collect($resource::collection($data->getCollection()))
            ),

            // 按常规处理
            default => new $resource($data)
        };

        return $this->responseSuccess($message, $data, $code, $headers, $options);
    }

    /**
     * @param mixed $normal
     *
     * @return mixed
     */
    protected function resolveDefaultValue(mixed $normal): mixed
    {
        try {
            return config('better-laravel.http.message_body_map', [])[$normal] ?? $normal;
        } catch(\Throwable) {
            return $normal;
        }
    }
}
