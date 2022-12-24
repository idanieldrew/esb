<?php

namespace Idanieldrew\Rabbitmq\Facades;

class RabbitmqFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Rabbitmq';
    }
}
