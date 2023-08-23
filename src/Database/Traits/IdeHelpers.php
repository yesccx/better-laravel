<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Database\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @method static QueryBuilder|EloquentBuilder|static|$this query() {@see \Illuminate\Database\Eloquent::query}
 * @method \Yesccx\BetterLaravel\Contracts\CustomLengthAwarePaginatorContract customPaginate(bool $allowFetchAll = false, ?int $perPage = null, ?int $page = null, bool $forceFetchAll = false, array $options = []) 自定义分页
 * @method \Yesccx\BetterLaravel\Contracts\CustomPaginatorContract customSimplePaginate(bool $allowFetchAll = false, ?int $perPage = null, ?int $page = null, bool $forceFetchAll = false, array $options = []) 自定义简单分页
 * @method QueryBuilder|EloquentBuilder|static|$this whereLike(mixed $fields, mixed $keywords, int $mode = 0) LIKE查询
 * @method QueryBuilder|EloquentBuilder|static|$this whenLike(mixed $fields, mixed $keywords, int $mode = 0) (when)LIKE查询
 * @method QueryBuilder|EloquentBuilder|static|$this whereToday(mixed $field) 查询是否为当日
 * @method QueryBuilder|EloquentBuilder|static|$this whereThisDay(mixed $field) 查询是否为当日
 * @method QueryBuilder|EloquentBuilder|static|$this whereInDay(mixed $field, mixed $day) 查询是否为某日
 * @method QueryBuilder|EloquentBuilder|static|$this whereThisWeek(mixed $field) 查询是否为本周
 * @method QueryBuilder|EloquentBuilder|static|$this whereThisMonth(mixed $field) 查询是否为本月
 * @method QueryBuilder|EloquentBuilder|static|$this whereInMonth(mixed $field, mixed $month) 查询是否为某月
 * @method QueryBuilder|EloquentBuilder|static|$this whereThisYear(mixed $field) 查询是否为本年
 * @method QueryBuilder|EloquentBuilder|static|$this whereInYear(mixed $field, mixed $year) 查询是否为某年
 * @method QueryBuilder|EloquentBuilder|static|$this whereGtDate(mixed $field, mixed $date) 查询是否大于指定日期
 * @method QueryBuilder|EloquentBuilder|static|$this whereGteDate(mixed $field, mixed $date) 查询是否大于等于指定日期
 * @method QueryBuilder|EloquentBuilder|static|$this whereLtDate(mixed $field, mixed $date) 查询是否小于指定日期
 * @method QueryBuilder|EloquentBuilder|static|$this whereLteDate(mixed $field, mixed $date) 查询是否小于等于指定日期
 * @method QueryBuilder|EloquentBuilder|static|$this whereBetweenDate(mixed $field, mixed $startTime = null, mixed $endTime = null, bool $forceFullDay = false) 查询是在指定日期范围内
 *
 * @see \Yesccx\BetterLaravel\Database\Supports\BuilderMacro
 */
trait IdeHelpers
{
}
