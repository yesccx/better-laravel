<?php

return [
    /**
     * 默认时间格式
     */
    'date_format' => env('YBL_DATE_FORMAT', 'Y-m-d H:i:s'),

    /**
     * 异常处理
     */
    'exception' => [
        /**
         * 遮掩异常细节
         *
         * 默认由app.debug控制
         */
        'cover_reason' => config('YBL_EX_COVER', !config('app.debug', true)),

        /**
         * 描述遮掩信息
         */
        'summary_cover' => config('YBL_EX_SUMMARY_COVER', '系统错误'),

        /**
         * 描述Missing异常信息
         */
        'summary_missing' => config('YBL_EX_SUMMARY_MISSING', '内容不存在'),
    ],

    /**
     * 类依赖映射
     */
    'dependencies' => [
        /**
         * 处理HTTP响应逻辑
         */
        \Yesccx\BetterLaravel\Contracts\HttpResponderContract::class => \Yesccx\BetterLaravel\Http\Responder::class,
    ],
];
