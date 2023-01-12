<?php

namespace Idanieldrew\Esb;

use Closure;
use Idanieldrew\Esb\Consume\Consumer;
use Idanieldrew\Esb\Publish\Publisher;

class Esb
{
    /**
     * @param string $routing_key
     * @param mixed $message
     * @return void
     */
    public function publish(string $routing_key, mixed $message)
    {
        $publish = resolve(Publisher::class);
        $publish->init();

        $message = new Message($message);
        $publish->publish($routing_key, $message);

        Connector::off($publish->getChannel(), $publish->getConnection());
    }

    public function consume(string $queue, Closure $closure)
    {
        $consume = resolve(Consumer::class);

        $consume->init();

        $consume->consume($queue,$closure);

        Connector::off($consume->getChannel(), $consume->getConnection());
    }
}
