<?php

namespace Scaffolding\Booter\Providers;

use Illuminate\Support\ServiceProvider;

class BooterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configure();
        $this->registerCommands();
    }

    /**
     * Setup the configuration for Booter.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/booter.php', 'booter');
    }

    /**
     * Setup the commands for Booter.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Scaffolding\Booter\Commands\MakeBooterHandler::class,
            ]);
        }
    }
}
