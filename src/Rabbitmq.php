<?php

namespace Idanieldrew\Rabbitmq;

use Idanieldrew\Rabbitmq\Publish\Publisher;

class Rabbitmq
{
    public function publish()
    {
        $publish = resolve(Publisher::class);
        $publish->init();
        $publish->publish();

        Connector::off($publish->getChannel(), $publish->getConnection());
    }
}
