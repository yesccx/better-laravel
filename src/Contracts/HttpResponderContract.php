<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Contracts;

use Illuminate\Http\JsonResponse;

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
}
