<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Exceptions\Traits;

use Yesccx\BetterLaravel\Contracts\HttpResponderContract;

/**
 * 处理异常渲染
 * PS：将异常通过HttpResponder进行响应
 */
trait RenderHttpResponse
{
    /**
     * 渲染异常信息
     *
     * @param Request $request
     */
    public function render($request)
    {
        return app(HttpResponderContract::class)->responseException($this, [
            'ignore_tracks' => false
        ]);
    }
}
