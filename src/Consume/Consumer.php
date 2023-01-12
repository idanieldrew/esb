<?php

namespace Idanieldrew\Esb\Consume;

use Closure;
use Exception;
use Idanieldrew\Esb\Connector;
use PhpAmqpLib\Exception\AMQPTimeoutException;

class Consumer extends Connector
{
    /**
     * @throws Exception
     */
    public function consume($queue, Closure $closure)
    {
        $queue = $queue ?? $this->getData('queue');

        try {
            $this->getChannel()->basic_consume(
                $queue,
                $this->getData('consumer_tag', ''),
                $this->getData('no_local', false),
                $this->getData('no_ack', true),
                $this->getData('exclusive', false),
                $this->getData('nowait', false),
                function ($msg) use ($closure) {
                    $closure($msg, $this);
                }
            );

            while (count($this->getChannel()->callbacks)) {
                $this->getChannel()->wait(null, false, 1);
            }
        } catch (Exception $e) {
            if ($e instanceof AMQPTimeoutException) {
                return true;
            }
            throw $e;
        }
        return true;
    }
}
