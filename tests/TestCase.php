<?php

namespace Scaffolding\Booter\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->migrate();
    }

    protected function getPackageProviders($app)
    {
        return [\Scaffolding\Booter\Providers\BooterServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cache.default', 'array');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    public function migrate()
    {
        $migrations = [
            \Scaffolding\Booter\Tests\Migrations\CreatePostsTable::class
        ];

        foreach ($migrations as $migration) {
            (new $migration)->up();
        }
    }
}
