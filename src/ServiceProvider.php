<?php

namespace VOLLdigital\Autosizeimages;

use Illuminate\Support\Facades\Event;
use Statamic\Events\AssetUploaded;
use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;
use VOLLdigital\Autosizeimages\Console\RefreshImages;
use VOLLdigital\Autosizeimages\Listeners\AutosizeListener;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = "autosizeimages";

    protected $scripts = [
        __DIR__ . '/../dist/cp.js'
    ];

    protected $routes = [
        'cp' => __DIR__ . '/../routes/cp.php'
    ];

    public function boot()
    {
        parent::boot();

        $this->checkRequirements();

        $this->registerPublishables();

        $this->registerCommands();

        $this->registerListeners();

        $this->registerNavigation();

        $this->registerViews();
    }

    public function register()
    {
        $this->app->bind('autosizer', function ($app) {
            return new Autosizer();
        });
    }

    private function checkRequirements()
    {
        if (!extension_loaded('gd')) {
            throw new \Exception("The autosizeimages addon needs the PHP GD extensions to work.");
        }
    }

    private function registerPublishables()
    {
        $this->publishes([
            __DIR__ . '/../config/statamic/autosizeimages.yaml' => config_path('statamic/autosizeimages.yaml'),
        ], 'autosizeimages-config');
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RefreshImages::class,
            ]);
        }
    }

    private function registerListeners()
    {
        Event::listen(AssetUploaded::class, [AutosizeListener::class, 'assetUploaded']);
    }

    private function registerNavigation()
    {
        Nav::extend(function ($nav) {
            $nav->create('Autosizeimages')
                ->section('Volldigital')
                ->route('autosizeimages.index')
                ->icon('picture')
                ->children([
                    'About' => cp_route('autosizeimages.index'),
                    'Settings' => cp_route('autosizeimages.settings')
                ]);
        });
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'autosizeimages');
    }
}
