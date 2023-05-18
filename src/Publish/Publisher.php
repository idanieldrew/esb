<?php

namespace Idanieldrew\Esb\Publish;

use Idanieldrew\Esb\Connector;

class Publisher extends Connector
{
    /**
     * @param string $routing_key
     * @param string $exchangeName
     * @param mixed $message
     * @return bool
     */
    public function publish(string $routing_key, string $exchangeName, mixed $message)
    {
        $this->getChannel()->basic_publish(
            $message,
            $exchangeName,
            $routing_key
        );

        return true;
    }
}
