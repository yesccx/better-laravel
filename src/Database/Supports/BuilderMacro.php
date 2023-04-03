<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Database\Supports;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Yesccx\BetterLaravel\Contracts\CustomLengthAwarePaginatorContract;
use Yesccx\BetterLaravel\Contracts\CustomPaginatorContract;

/**
 * 数据库查询方法宏扩展
 */
final class BuilderMacro
{
    public function customPaginate(): callable
    {
        /**
         * 自定义分页
         *
         * @param bool $allowFetchAll 是否允许获取全部
         * @param null|int $perPage 每页数量
         * @param null|int $page 页码
         * @param bool $forceFetchAll 是否强制获取全部
         * @param array $options 扩展选项 @see PaginatorOptions::data
         * @return CustomLengthAwarePaginatorContract
         */
        return function (
            bool $allowFetchAll = false,
            ?int $perPage = null,
            ?int $page = null,
            bool $forceFetchAll = false,
            array $options = []
        ): CustomLengthAwarePaginatorContract {
            /** @var Builder $this */

            $request = request();

            $options = PaginatorOptions::init($options);

            // 是否获取全部 = 强制获取全部 || 开启允许获取全部时指定获取全部
            $fetchAll = (bool) match (true) {
                $forceFetchAll => true,
                $allowFetchAll => $request->input($options['fetch_all_field'], $options['fetch_all']),
                default        => false
            };

            // 处理页码、每页数量，防止数值范围溢出
            $page = $page ?? (int) $request->input($options['page_field'], $options['page']);
            $perPage = $perPage ?? (int) $request->input($options['per_page_field'], $options['per_page']);
            $perPage = min(max($perPage, 1), $options['max_per_page']);

            return app(CustomLengthAwarePaginatorContract::class, [
                'paginate' => match ($fetchAll) {
                    true   => $this->paginator(
                        items: $this->get(),
                        total: 0,
                        perPage: 1,
                        currentPage: 1,
                        options: []
                    ),
                    default => $this->paginate(perPage: $perPage, page: $page)
                },
                'fetchAll' => $fetchAll,
            ]);
        };
    }

    public function customSimplePaginate(): callable
    {
        /**
         * 自定义简单分页
         *
         * @param bool $allowFetchAll 是否允许获取全部
         * @param null|int $perPage 每页数量
         * @param null|int $page 页码
         * @param bool $forceFetchAll 是否强制获取全部
         * @param array $options 扩展选项 @see PaginatorOptions::data
         * @return CustomPaginatorContract
         */
        return function (
            bool $allowFetchAll = false,
            ?int $perPage = null,
            ?int $page = null,
            bool $forceFetchAll = false,
            array $options = []
        ): CustomPaginatorContract {
            /** @var Builder $this */

            $request = request();

            $options = PaginatorOptions::init($options);

            // 是否获取全部 = 强制获取全部 || 开启允许获取全部时指定获取全部
            $fetchAll = (bool) match (true) {
                $forceFetchAll => true,
                $allowFetchAll => $request->input($options['fetch_all_field'], $options['fetch_all']),
                default        => false
            };

            // 处理页码、每页数量，防止数值范围溢出
            $page = $page ?? (int) $request->input($options['page_field'], $options['page']);
            $perPage = $perPage ?? (int) $request->input($options['per_page_field'], $options['per_page']);
            $perPage = min(max($perPage, 1), $options['max_per_page']);

            return app(CustomPaginatorContract::class, [
                'paginate' => match ($fetchAll) {
                    true   => $this->simplePaginator(
                        items: $this->get(),
                        perPage: 1,
                        currentPage: 1,
                        options: []
                    ),
                    default => $this->simplePaginate(perPage: $perPage, page: $page)
                },
                'fetchAll' => $fetchAll,
            ]);
        };
    }

    public function whereLike(): callable
    {
        /**
         * LIKE查询
         *
         * @param mixed $fields 查询字段
         * @param mixed $keywords 查询值
         * @param int $mode 0-all;1-start;2-end;3-normal
         *
         * @return Builder
         */
        return function (mixed $fields, mixed $keywords, int $mode = 0): Builder {
            /** @var Builder $this */

            if (
                empty($fields = value($fields)) ||
                empty($keywords = value($keywords))
            ) {
                return $this;
            }

            $keywords = match ($mode) {
                1       => "%{$keywords}",
                2       => "{$keywords}%",
                3       => $keywords,
                default => "%{$keywords}%"
            };

            return $this->where(
                fn ($query)     => collect($fields)->each(
                    fn ($field) => $query->orWhere($field, 'like', $keywords)
                )
            );
        };
    }

    public function whenLike(): callable
    {
        /**
         * (when)LIKE查询
         *
         * @param mixed $fields 查询字段
         * @param mixed $keywords 查询值
         * @param int $mode 0-all 1-start 2-end 3-normal
         *
         * @return Builder
         */
        return function (mixed $fields, mixed $keywords, int $mode = 0): Builder {
            /** @var Builder $this */

            if (empty($keywords = value($keywords))) {
                return $this;
            }

            return $this->whereLike($fields, $keywords, $mode);
        };
    }

    public function whereToday(): callable
    {
        /**
         * 查询是否为当日
         *
         * @uses whereThisDay()
         *
         * @param mixed $field 查询字段
         *
         * @return Builder
         */
        return function (mixed $field): Builder {
            /** @var Builder $this */

            return $this->whereThisDay($field);
        };
    }

    public function whereThisDay(): callable
    {
        /**
         * 查询是否为当日
         *
         * @param mixed $field 查询字段
         *
         * @return Builder
         */
        return function (mixed $field): Builder {
            /** @var Builder $this */

            return $this->whereBetweenDate($field, Carbon::now(), Carbon::now(), true);
        };
    }

    public function whereInDay(): callable
    {
        /**
         * 查询是否为某日
         *
         * @param mixed $field 查询字段
         * @param mixed $month 日期 2022-01-01
         *
         * @return Builder
         */
        return function (mixed $field, mixed $day): Builder {
            /** @var Builder $this */

            $day = Carbon::make($day);

            return $this->whereBetweenDate($field, $day, $day, forceFullDay: true);
        };
    }

    public function whereThisWeek(): callable
    {
        /**
         * 查询是否为本周
         *
         * @param mixed $field 查询字段
         *
         * @return Builder
         */
        return function (mixed $field): Builder {
            /** @var Builder $this */

            return $this->whereBetweenDate($field, Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek(), forceFullDay: true);
        };
    }

    public function whereThisMonth(): callable
    {
        /**
         * 查询是否为本月
         *
         * @param mixed $field 查询字段
         *
         * @return Builder
         */
        return function (mixed $field): Builder {
            /** @var Builder $this */

            return $this->whereInMonth($field, Carbon::now());
        };
    }

    public function whereInMonth(): callable
    {
        /**
         * 查询是否为某月
         *
         * @param mixed $field 查询字段
         * @param mixed $month 月份 2022-01
         *
         * @return Builder
         */
        return function (mixed $field, mixed $month): Builder {
            /** @var Builder $this */

            $month = Carbon::make($month);

            return $this->whereBetweenDate($field, $month->startOfMonth(), $month->endOfMonth(), forceFullDay: true);
        };
    }

    public function whereThisYear(): callable
    {
        /**
         * 查询是否为本年
         *
         * @param mixed $field 查询字段
         *
         * @return Builder
         */
        return function (mixed $field): Builder {
            /** @var Builder $this */

            return $this->whereInYear($field, Carbon::now());
        };
    }

    public function whereInYear(): callable
    {
        /**
         * 查询是否为某年
         *
         * @param mixed $field 查询字段
         * @param mixed $year 年份 2022
         *
         * @return Builder
         */
        return function (mixed $field, mixed $year): Builder {
            /** @var Builder $this */

            $year = Carbon::make($year);

            return $this->whereBetweenDate($field, $year->startOfYear(), $year->endOfYear(), forceFullDay: true);
        };
    }

    public function whereGtDate(): callable
    {
        /**
         * 查询是否大于指定日期
         *
         * @param mixed $field 查询字段
         * @param mixed $date 日期(默认为当前时间)
         *
         * @return Builder
         */
        return function (mixed $field, mixed $date = null): Builder {
            /** @var Builder $this */

            $field = value($field);
            $date = Carbon::make(value($date) ?: Carbon::now());

            return $this->where($field, '>', $date->format('Y-m-d H:i:s'));
        };
    }

    public function whereGteDate(): callable
    {
        /**
         * 查询是否大于等于指定日期
         *
         * @param mixed $field 查询字段
         * @param mixed $date 日期(默认为当前时间)
         *
         * @return Builder
         */
        return function (mixed $field, mixed $date = null): Builder {
            /** @var Builder $this */

            $field = value($field);
            $date = Carbon::make(value($date) ?: Carbon::now());

            return $this->where($field, '>=', $date->format('Y-m-d H:i:s'));
        };
    }

    public function whereLtDate(): callable
    {
        /**
         * 查询是否小于指定日期
         *
         * @param mixed $field 查询字段
         * @param mixed $date 日期(默认为当前时间)
         *
         * @return Builder
         */
        return function (mixed $field, mixed $date = null): Builder {
            /** @var Builder $this */

            $field = value($field);
            $date = Carbon::make(value($date) ?: Carbon::now());

            return $this->where($field, '<', $date->format('Y-m-d H:i:s'));
        };
    }

    public function whereLteDate(): callable
    {
        /**
         * 查询是否小于等于指定日期
         *
         * @param mixed $field 查询字段
         * @param mixed $date 日期(默认为当前时间)
         *
         * @return Builder
         */
        return function (mixed $field, mixed $date = null): Builder {
            /** @var Builder $this */

            $field = value($field);
            $date = Carbon::make(value($date) ?: Carbon::now());

            return $this->where($field, '<=', $date->format('Y-m-d H:i:s'));
        };
    }

    public function whereBetweenDate(): callable
    {
        /**
         * 查询是在指定日期范围内
         *
         * @param mixed $field 查询字段
         * @param mixed $startDate 开始日期
         * @param mixed $endDate 结束日期
         * @param bool $forceFullDay 是否为强制全天
         *
         * @return Builder
         */
        return function (
            string $field,
            mixed $startDate = null,
            mixed $endDate = null,
            bool $forceFullDay = false
        ): Builder {
            /** @var Builder $this */

            if (
                empty(value($startDate)) ||
                empty(value($endDate))
            ) {
                return $this;
            }

            $field = value($field);

            return $this->whereBetween(
                $field,
                match ($forceFullDay) {
                    true    => [Carbon::make($startDate)->startOfDay(), Carbon::make($endDate)->endOfDay()],
                    default => [$startDate, $endDate]
                }
            );
        };
    }
}
