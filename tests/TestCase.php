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
        $app['config']->set('rabbitmq.host', 'task_rabbitmq');
        $app['config']->set('rabbitmq.port', '5672');
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
