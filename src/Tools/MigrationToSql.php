<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Tools;

use Illuminate\Database\Migrations\Migrator;

/**
 * 迁移文件转换至SQL语句
 * TODO: 写法有些取巧，待完善
 */
final class MigrationToSql extends Migrator
{
    protected function __construct()
    {
        $migrator = app('migrator');

        // 利用反射提取构造Migrator类时所需要的参数
        $reflectionClass = new \ReflectionClass($migrator);

        [$events, $files, $resolver, $repository] = array_map(
            function ($name) use ($reflectionClass, $migrator) {
                $property = $reflectionClass->getProperty($name);

                $property->setAccessible(true);

                return $property->getValue($migrator);
            },
            ['events', 'files', 'resolver', 'repository']
        );

        parent::__construct($repository, $resolver, $files, $events);
    }

    /**
     * Make instance
     *
     * @return static
     */
    public static function make(): static
    {
        return new static;
    }

    /**
     * Handle
     *
     * @param string $file
     * @param string $method
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function handle(string $file, string $method = 'up'): array
    {
        $migration = $this->resolvePath($file);

        try {
            return collect($this->getQueries($migration, $method))->map(
                fn ($query) => $query['query']
            )->toArray();
        } catch (\Throwable $e) {
            throw new \Exception('转换SQL语句异常');
        }
    }
}
