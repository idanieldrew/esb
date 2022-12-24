<?php


use Illuminate\Support\Facades\Facade;

/**
 * @method static publish()
 */
class RabbitmqFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Rabbitmq';
    }
}
