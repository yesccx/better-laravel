<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Database;

use Illuminate\Pagination\LengthAwarePaginator;
use Yesccx\BetterLaravel\Database\Supports\PaginatorOptions;

/**
 * 自定义分页器
 */
final class CustomLengthAwarePaginator extends LengthAwarePaginator
{
    /**
     * 标识是否取回所有数据
     *
     * @var bool
     */
    protected bool $fetchAll = false;

    /**
     * @param LengthAwarePaginator $paginate 原始分页对象
     * @param bool $fetchAll 标识是否取回所有数据
     *
     * @return void
     */
    public function __construct(LengthAwarePaginator $paginate, bool $fetchAll = false)
    {
        parent::__construct(
            items: $paginate->getCollection(),
            total: $paginate->total(),
            perPage: $paginate->perPage(),
            currentPage: $paginate->currentPage(),
            options: $paginate->getOptions()
        );

        $this->fetchAll = $fetchAll;
    }

    /**
     * **重写方法**
     *
     * 重新定义分页内容的响应格式
     *
     * @return array
     */
    public function toArray(): array
    {
        return match ($this->fetchAll) {
            true    => ['list' => $this->getCollection()],
            default => [
                'paginate' => [
                    'total'         => (int) $this->total(),
                    'current_page'  => (int) $this->currentPage(),
                    'current_count' => (int) count($this->getCollection()),
                    'page_size'     => (int) $this->perPage(),
                ],
                'list' => $this->getCollection(),
            ]
        };
    }

    /**
     * 构建空数据分页对象
     *
     * @param bool $fetchAll 标识是否取回所有数据
     *
     * @return self
     */
    public static function toEmpty(bool $fetchAll = false): self
    {
        return self::resolve(collect(), fetchAll: $fetchAll);
    }

    /**
     * 解析出分页对象
     *
     * @param mixed $items
     * @param int $total
     * @param null|int $perPage
     * @param null|int $currentPage
     * @param array $options (path, query, fragment, pageName)
     * @param bool $fetchAll 标识是否取回所有数据
     * @param ?int $page
     * @return self
     */
    public static function resolve(
        mixed $items,
        int $total = 0,
        ?int $perPage = null,
        ?int $page = null,
        bool $fetchAll = false
    ): self {
        $request = request();

        $options = PaginatorOptions::init();

        $items = collect($items);

        // 处理页码、每页数量，防止数值范围溢出
        $page = $page ?? (int) $request->input($options['page_field'], $options['page']);
        $perPage = $perPage ?? (int) $request->input($options['per_page_field'], $options['per_page']);
        $perPage = min(max($perPage, 1), $options['max_per_page']);

        $total = $items->count();

        return new self(
            new LengthAwarePaginator(
                items: $items,
                total: $total,
                perPage: $perPage,
                currentPage: $page
            ),
            $fetchAll
        );
    }
}
