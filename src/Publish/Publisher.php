<?php

namespace Idanieldrew\Esb\Publish;

use Idanieldrew\Esb\Connector;

class Publisher extends Connector
{
    /**
     * @param string $routing_key
     * @param mixed $message
     * @return bool
     */
    public function publish(string $routing_key, mixed $message)
    {
        $this->getChannel()->basic_publish(
            $message,
            '',
            $routing_key
        );
        return true;
    }
}
