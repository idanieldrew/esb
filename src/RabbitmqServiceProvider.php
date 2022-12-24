<?php

namespace Idanieldrew\Rabbitmq;

use Idanieldrew\Rabbitmq\Publish\Publisher;
use Illuminate\Support\ServiceProvider;
use Rabbitmq;

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
        /*$this->app->singleton('Publish', function () {
            return new Publisher();
        });*/
    }
}
