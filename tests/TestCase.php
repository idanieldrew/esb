<?php

namespace Idanieldrew\Esb\Test;

use Idanieldrew\Esb\EsbServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use ReflectionClass;
use ReflectionException;

class TestCase extends Orchestra
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app)
    {
        return [
            EsbServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('esb.host', 'task_rabbitmq');
        $app['config']->set('esb.port', '5672');
        $app['config']->set('esb.queue', 'aaaa');
        $app['config']->set('esb.user', '5672');
        $app['config']->set('esb.password', '5672');
        $app['config']->set('esb.durable_queue', '5672');
        $app['config']->set('esb.routing_key', '5672');
        $app['config']->set('esb.exchange_passive', '5672');
        $app['config']->set('esb.exchange_durable', '5672');
        $app['config']->set('esb.exchange_auto_delete', '5672');
        $app['config']->set('esb.exchange_internal', '5672');
        $app['config']->set('esb.exchange_nowait', '5672');
        $app['config']->set('esb.exchange_properties', '5672');
        $app['config']->set('esb.timeout', '5672');
        $app['config']->set('esb.auto_delete', '5672');
        $app['config']->set('esb.exclusive', '5672');
        $app['config']->set('esb.passive', '5672');
        $app['config']->set('esb.durable', '5672');
    }

    /**
     * set type before mocking
     *
     * @param $class
     * @param $property
     * @param $mock
     * @param $value
     * @return void
     * @throws ReflectionException
     */
    protected function setType($class, $property, $mock, $value)
    {
        $ref = new ReflectionClass($class);
        $property = $ref->getProperty($property);
        $property->setValue($mock, $value);
    }
}
