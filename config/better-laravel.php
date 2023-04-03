<?php

return [
    /**
     * 默认时间格式
     */
    'date_format' => env('YBL_DATE_FORMAT', 'Y-m-d H:i:s'),

    /**
     * Http模块
     */
    'http' => [
        /**
         * 路由扫描
         */
        'route_scanning' => [
            [
                'path'    => 'routes/modules',
                'options' => [
                    'prefix'     => 'api',
                    'middleware' => 'api',
                ],
            ],
        ],
    ],

    /**
     * 异常处理
     */
    'exception' => [
        /**
         * 忽略异常栈信息
         *
         * 默认由app.debug控制
         */
        'ignore_tracks' => env('YBL_EX_IGNORE_TRACKS', !config('app.debug', true)),

        /**
         * 忽略异常后的描述
         */
        'ignored_summary' => env('YBL_EX_IGNORED_SUMMARY', '系统错误'),

        /**
         * Missing异常描述
         */
        'missing_summary' => env('YBL_EX_MISSING_SUMMARY', '内容不存在'),

        /**
         * 使用异常错误码作为HTTP响应码
         * PS: 请谨慎开启
         */
        'use_exception_code' => env('YBL_EX_USE_EXCEPTION_CODE', false),
    ],

    /**
     * 类映射
     */
    'binds' => [
        /**
         * 数据库分页逻辑
         */
        \Yesccx\BetterLaravel\Contracts\CustomLengthAwarePaginatorContract::class => \Yesccx\BetterLaravel\Database\CustomLengthAwarePaginator::class,
        \Yesccx\BetterLaravel\Contracts\CustomPaginatorContract::class            => \Yesccx\BetterLaravel\Database\CustomPaginator::class,
    ],

    /**
     * 单例映射
     */
    'singletons' => [
        /**
         * 处理HTTP响应逻辑
         */
        \Yesccx\BetterLaravel\Contracts\HttpResponderContract::class => \Yesccx\BetterLaravel\Http\Responder::class,
    ],
];
