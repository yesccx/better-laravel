<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Console;

use Illuminate\Console\Command;

/**
 * Laravel部署优化
 *
 * PS: 同时进行路由缓存、配置缓存、事件缓存等以及composer优化
 *
 * @see \Illuminate\Foundation\Console\OptimizeClearCommand 参照该类的反向实现
 */
final class OptimizeAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:all {--f|force : 强制优化.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel部署优化.';

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
        if (!$this->option('force')) {
            if (!$this->confirm('是否确认优化，这将影响部分代码的即时性，建议仅在生产环境使用', false)) {
                return self::SUCCESS;
            }
        }

        $this->call('event:cache');
        $this->call('view:cache');
        $this->call('route:cache');
        $this->call('config:cache');
        passthru('composer dump-autoload --optimize');

        $this->info('优化成功！');

        return self::SUCCESS;
    }
}
