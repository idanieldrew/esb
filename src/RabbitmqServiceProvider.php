<?php

namespace Idanieldrew\Rabbitmq;

use Illuminate\Support\ServiceProvider;

class RabbitmqServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('Rabbitmq', function () {
            return new Rabbitmq();
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/rabbitmq.php',
            'rabbitmq'
        );
    }
}
