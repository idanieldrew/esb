<?php

namespace Idanieldrew\Rabbitmq\Publish;

use Idanieldrew\Rabbitmq\Connector;

class Publisher extends Connector
{
    public function publish()
    {
        $this->getChannel()->basic_publish(
            "msg",
            "exchange",
            "routing_key",
            "mandatory",
            "immediate",
            "ticket"
        );
        return true;
    }
}
