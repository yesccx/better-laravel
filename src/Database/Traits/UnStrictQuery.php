<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Database\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Config;

/**
 * 非严格模式的查询
 */
trait UnStrictQuery
{
    /**
     * 构建非严格模式的查询
     *
     * @param null|string $referConnectionName 参照的连接名称
     * @return QueryBuilder|EloquentBuilder|static
     */
    public static function unStrictQuery(?string $referConnectionName = null): QueryBuilder|EloquentBuilder|static
    {
        $referConnectionName ??= config('database.default', 'mysql');

        $connectionName = "un_strict_{$referConnectionName}";

        if (!Config::has($connectionConfig = "database.connections.{$connectionName}")) {
            Config::set($connectionConfig, array_merge(
                config("database.connections.{$referConnectionName}", []),
                ['strict' => false]
            ));
        }

        return static::on($connectionName);
    }
}
