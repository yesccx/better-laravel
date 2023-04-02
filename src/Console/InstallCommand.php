<?php

declare(strict_types = 1);

namespace Yesccx\BetterLaravel\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

final class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'better-laravel:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'better-laravel-provider']);

        $this->comment('Publishing Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'better-laravel-config']);

        $this->registerBetterLaravelServiceProvider();

        $this->info('Better Laravel installed successfully.');
    }

    /**
     * Register the Better-Laravel service provider in the application configuration file.
     *
     * @return void
     */
    protected function registerBetterLaravelServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace . '\\Providers\\BetterLaravelProvider::class')) {
            return;
        }

        $lineEndingCount = [
            "\r\n" => mb_substr_count($appConfig, "\r\n"),
            "\r"   => mb_substr_count($appConfig, "\r"),
            "\n"   => mb_substr_count($appConfig, "\n"),
        ];

        $eol = array_keys($lineEndingCount, max($lineEndingCount))[0];

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\RouteServiceProvider::class," . $eol,
            "{$namespace}\\Providers\RouteServiceProvider::class," . $eol . "        {$namespace}\Providers\BetterLaravelProvider::class," . $eol,
            $appConfig
        ));

        file_put_contents(app_path('Providers/BetterLaravelProvider.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/BetterLaravelProvider.php'))
        ));
    }
}
