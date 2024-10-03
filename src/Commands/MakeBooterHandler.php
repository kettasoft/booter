<?php

namespace Scaffolding\Booter\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeBooterHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booter:make-handler {name} {--module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event handler class';

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
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $module = $this->option('module');

        // Get config values for paths and namespaces
        $defaultNamespace = config('booter.default_namespace', 'App\\Boot');
        $defaultPath = config('booter.default_path', app_path('Boot/'));
        $modulesNamespace = config('booter.modules_namespace', 'Modules\\');
        $modulesPath = config('booter.modules_path', 'Modules/:module/Entities/Boot/');

        // Replace the :module placeholder with the actual module name in the path
        $modulesPath = str_replace(':module', $module, $modulesPath);

        if ($module) {
            // Check if the module exists
            $modulePath = base_path($modulesPath);
            if (!File::exists($modulePath)) {
                $this->error("Module {$module} does not exist!");
                return;
            }

            // Define the handler path in the module
            $filePath = base_path("{$modulesPath}/{$name}.php");
        } else {
            // Default path in the app directory
            $filePath = base_path("{$defaultPath}/{$name}.php");
        }


        // Check if the handler already exists
        if (file_exists($filePath)) {
            $this->error("Handler {$name} already exists!");
            return;
        }

        // Generate the handler from a stub
        $stub = file_get_contents(__DIR__ . '/stubs/booter-handler.stub');
        $stub = str_replace('{{namespace}}', $module ? "{$modulesNamespace}{$module}\\Entities\\Boot" : $defaultNamespace, $stub);
        $stub = str_replace('{{class}}', $name, $stub);

        // Create the directory if it does not exist
        File::ensureDirectoryExists(dirname($filePath));

        file_put_contents($filePath, $stub);
        $this->info("Handler {$name} created successfully in " . ($module ? "module {$module}" : "app/Boot"));
    }
}
