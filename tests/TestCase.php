<?php

namespace VOLLdigital\Autosizeimages\Tests;

use VOLLdigital\Autosizeimages\ServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Extend\Manifest;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;


abstract class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            StatamicServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'volldigital/autosizeimages' => [
                'id' => 'volldigital/autosizeimages',
                'namespace' => 'Autosizeimages\\',
            ],
        ];

        Statamic::pushActionRoutes(function () {
            return require_once realpath(__DIR__ . '/../routes/actions.php');
        });
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $configs = ['assets', 'cp', 'forms', 'routes', 'static_caching', 'sites', 'stache', 'system', 'users'];

        foreach ($configs as $config) {
            $app['config']->set("statamic.$config", require __DIR__ . "/../vendor/statamic/cms/config/{$config}.php");
        }
    }

    public function tearDown(): void
    {
        // destroy $app
        if ($this->app) {
            $this->callBeforeApplicationDestroyedCallbacks();

            // this is the issue.
            // $this->app->flush();

            $this->app = null;
        }

        // call the parent teardown
        parent::tearDown();
    }
}
