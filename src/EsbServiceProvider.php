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
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/esb.php',
            'esb'
        );
    }
}
