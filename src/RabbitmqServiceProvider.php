<?php

namespace Idanieldrew\Rabbitmq;

use Idanieldrew\Rabbitmq\Queue\Connectors\RabbitmqConnector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class RabbitmqServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('Rabbitmq', function () {
            return new Rabbitmq();
        });

        $manager = $this->app['queue'];

        $manager->addConnector('rabbitmq', function () {
            return new RabbitmqConnector;
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/rabbitmq.php',
            'rabbitmq'
        );
    }
}
