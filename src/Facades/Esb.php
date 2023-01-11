<?php

namespace Idanieldrew\Esb\Facades;

/**
 * @method static publish(string $routing_key, $message)
 * @method static consume(string $queue = null)
 */
class Esb extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Esb';
    }
}
