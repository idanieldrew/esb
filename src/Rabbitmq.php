<?php

namespace Idanieldrew\Rabbitmq;

use Closure;
use Idanieldrew\Rabbitmq\Consume\Consumer;
use Idanieldrew\Rabbitmq\Publish\Publisher;

class Rabbitmq
{
    /**
     * @param string $routing_key
     * @param mixed $message
     */
    public function publish(string $routing_key, mixed $message)
    {
        $publish = resolve(Publisher::class);
        $publish->init();
        $message = new Message($message);
        $publish->publish($routing_key, $message);

        Connector::off($publish->getChannel(), $publish->getConnection());

        echo 'ok';
    }

    public function consume(string $queue)
    {
        $consume = resolve(Consumer::class);

        $consume->init();

        $consume->consume($queue);

        Connector::off($consume->getChannel(), $consume->getConnection());
    }
}
