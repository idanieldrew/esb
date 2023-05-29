<?php

namespace Idanieldrew\Esb\Publish;

use Idanieldrew\Esb\Connector;

class Publisher extends Connector
{
    /**
     * @param string $routing_key
     * @param mixed $message
     * @param mixed $exchangeName
     * @return bool
     */
    public function publish(string $routing_key, mixed $message, mixed $exchangeName)
    {
        // new
        $this->queueOperation();

        $this->getChannel()->basic_publish(
            $message,
            $exchangeName,
            $routing_key
        );

        return true;
    }

    public function queueOperation()
    {
        $this->getChannel()->queue_declare(
            $this->getData('queue'),
            $this->getData('passive'),
            $this->getData('durable'),
            $this->getData('exclusive'),
            $this->getData('auto_delete')
        );
    }
}
