<?php

namespace Idanieldrew\Rabbitmq\Publish;

use Idanieldrew\Rabbitmq\Connector;

class Publisher extends Connector
{
    /**
     * @param string $routing
     * @param mixed $message
     * @return true
     */
    public function publish(string $routing, mixed $message)
    {
        $this->getChannel()->basic_publish(
            $message,
            '',
            'hello'
        );
        return true;
    }
}
