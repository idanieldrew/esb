<?php

namespace Idanieldrew\Rabbitmq\Facades;

use Closure;

/**
 * @method static publish(string $routing_key, $message)
 * @method static consume(string $queue)
 */
class RabbitmqFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Rabbitmq';
    }
}
