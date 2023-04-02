<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Throwable;
use Yesccx\BetterLaravel\Tools\FileCollector;
use Yesccx\BetterLaravel\Tools\MigrationToSql;

/**
 * 将迁移文件转换为SQL语句
 */
final class MigrateToSqlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:to-sql {--path= : 要转换的迁移文件路径}
                {--type=up : up/down}
                {--root=database/migrations : 迁移文件根目录}';

    /**
     * The console command description.
     *d
     * @var string
     */
    protected $description = '将迁移文件转换为SQL语句.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $path = $this->option('path');
        $type = $this->option('type');

        if (empty($path)) {
            return $this->fail('请指定要转换的迁移文件的路径！');
        } elseif (!in_array($type, ['up', 'down'])) {
            return $this->fail('类型无效，仅限 up/down！');
        }

        try {
            // 匹配迁移文件
            $matchMigrations = array_values(
                array_filter(
                    FileCollector::scan($this->option('root')),
                    fn ($migration) => Str::contains($migration, $path, true)
                )
            );

            $this->borderLine();
            $this->comment("-- Input: {$path} / {$type}");
            $this->comment('-- Datetime: ' . now());
            $this->comment('-- Total: ' . count($matchMigrations));
            $this->borderLine();

            if (empty($matchMigrations)) {
                $this->info('Not Matched.');
                $this->borderLine();
            } else {
                $tool = MigrationToSql::make();

                foreach ($matchMigrations as $path) {
                    $this->comment('-- Migrate：' . basename($path));

                    foreach ($tool->handle($path, $type) as $rawSql) {
                        $this->newLine();
                        $this->info("{$rawSql};");
                    }

                    $this->borderLine();
                }
            }
        } catch (Throwable $e) {
            return $this->fail("转换异常：{$e->getMessage()}");
        }

        return self::SUCCESS;
    }

    /**
     * 分隔行
     *
     * @return void
     */
    protected function borderLine(): void
    {
        $this->info('--------------------------------------------------');
    }

    /**
     * Fail
     *
     * @param string $message
     * @return int
     */
    protected function fail(string $message): int
    {
        $this->error($message);

        return self::SUCCESS;
    }
}
