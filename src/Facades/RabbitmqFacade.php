<?php

namespace Idanieldrew\Rabbitmq\Facades;

/**
 * * @method static publish()
 */
class RabbitmqFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Rabbitmq';
    }
}
