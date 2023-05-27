<?php

namespace Idanieldrew\Esb;

use Idanieldrew\Esb\Queue\Connectors\EsbConnector;
use Illuminate\Support\ServiceProvider;

class EsbServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('Esb', function () {
            return new Esb();
        });

        $manager = $this->app['queue'];

        $manager->addConnector('esb', function () {
            return new EsbConnector;
        });

        $this->offerPublishing();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/esb.php',
            'esb'
        );
    }

    /**
     * Publish
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/esb.php' => config_path('esb.php')
        ], 'esb-config');
    }
}
