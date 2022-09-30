<?php

namespace Sassnowski\Venture\Dashboard\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use const PHP_EOL;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'venture:dashboard:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Venture Dashboard resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Venture Dashboard Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'venture-dashboard-assets']);

        $this->comment('Publishing Venture Dashboard Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'venture-dashboard-provider']);

        $this->registerVentureDashboardServiceProvider();
    }

    /**
     * Register the Venture Dashboard service provider in the application configuration file.
     *
     * @return void
     */
    private function registerVentureDashboardServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace.'\\Providers\\VentureDashboardServiceProvider::class')) {
            return;
        }

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL,
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL."        {$namespace}\Providers\VentureDashboardServiceProvider::class,".PHP_EOL,
            $appConfig
        ));

        file_put_contents(app_path('Providers/VentureDashboardServiceProvider.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/VentureDashboardServiceProvider.php'))
        ));
    }
}
