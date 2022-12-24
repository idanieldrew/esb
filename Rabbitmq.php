<?php

use Idanieldrew\Rabbitmq\Connector;
use Idanieldrew\Rabbitmq\Publish\Publisher;

class Rabbitmq
{
    public function publish()
    {
        dd(222);
        $publish = resolve(Publisher::class);
        $publish->init();
        $publish->publish();

        Connector::off($publish->getChannel(), $publish->getConnection());
    }
}
