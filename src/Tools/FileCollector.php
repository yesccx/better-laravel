<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Tools;

use Illuminate\Support\Facades\Storage;

/**
 * 文件收集器
 */
final class FileCollector
{
    /**
     * 扫描目录，进行收集
     *
     * @param string $scanningPath
     * @return array
     */
    public static function scan(string $scanningPath): array
    {
        if (empty($scanningPath)) {
            return [];
        }

        return array_map(
            fn ($file) => base_path($file),
            Storage::build(base_path())->files($scanningPath)
        );
    }
}
