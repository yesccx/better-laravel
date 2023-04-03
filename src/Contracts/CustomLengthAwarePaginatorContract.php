<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Contracts;

interface CustomLengthAwarePaginatorContract
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * 构建空数据分页对象
     *
     * @param bool $fetchAll 标识是否取回所有数据
     *
     * @return self
     */
    public static function toEmpty(bool $fetchAll = false): self;

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
    ): self;
}
