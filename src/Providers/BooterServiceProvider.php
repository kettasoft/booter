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
        $this->registerCommands();

        $this->publishes([
            __DIR__ . '/../../config/booter.php' => config_path('booter.php'),
        ], 'config');
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
