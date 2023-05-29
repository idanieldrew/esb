<?php

namespace Idanieldrew\Esb\Facades;

use Closure;

/**
 * @method static publish(string $routing_key, $message, string $exchangeName = null)
 * @method static consume(string $queue, Closure $closure)
 */
class Esb extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Esb';
    }
}
