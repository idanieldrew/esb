<?php

namespace Idanieldrew\Esb;

use Closure;
use Idanieldrew\Esb\Consume\Consumer;
use Idanieldrew\Esb\Publish\Publisher;

class Esb
{
    /**
     * Publish it
     *
     * @param string $routing_key
     * @param mixed $message
     * @param string|null $exchangeName
     * @return void
     */
    public function publish(string $routing_key, mixed $message, string $exchangeName = null)
    {
        $exchangeName = $exchangeName ?? config('esb.exchange');

        $publish = resolve(Publisher::class);
        $publish->init();

        $message = new Message($message);
        $publish->publish($routing_key, $message, $exchangeName);

        Connector::off($publish->getChannel(), $publish->getConnection());
    }

    /**
     * Consume it
     *
     * @param string $queue
     * @param Closure $closure
     * @return void
     * @throws \Exception
     */
    public function consume(string $queue, Closure $closure)
    {
        if (empty($queue)) {
            $queue = config('esb.queue');
        }

        $consume = resolve(Consumer::class);
        $consume->init();

        $consume->consume($queue, $closure);

        Connector::off($consume->getChannel(), $consume->getConnection());
    }
}
