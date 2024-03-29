<?php

namespace Idanieldrew\Esb\Consume;

use Closure;
use Exception;
use Idanieldrew\Esb\Connector;
use Illuminate\Support\Facades\App;
use PhpAmqpLib\Exception\AMQPTimeoutException;

class Consumer extends Connector
{
    protected bool $res;

    /**
     * @throws Exception
     */
    public function consume($queue, Closure $closure = null)
    {
        $this->res = true;

        $queue = $queue ?? $this->getData('queue');

        $c = function ($msg) use ($closure) {
            $closure($msg, null);
        };
        if (App::runningUnitTests()) {
            $c = null;
        }

        /*if ($this->getData('exchange') !== null) {
            $queue = $this->queueOperation($queue);
        }*/
        $queue = $this->queueOperation($queue);

        try {
            $this->consumeQueue($queue, $c);

            while (count($this->getChannel()->callbacks)) {
                $this->getChannel()->wait(null, false, $this->getData('timeout', 10));
            }
        } catch (Exception $e) {
            if ($e instanceof AMQPTimeoutException) {
                return true;
            }
            throw $e;
        }
        return $this->res;
    }

    public function queueOperation($queue = null)
    {
        list($queue, ,) = $this->getChannel()->queue_declare(
            $queue,
            $this->getData('passive'),
            $this->getData('durable'),
            $this->getData('exclusive'),
            $this->getData('auto_delete')
        );

        if ($this->getData('exchange') !== null) {
            $this->getChannel()->queue_bind(
                $queue,
                $this->getData('exchange'),
                $this->getData('routing_key'),
            );
        }
        return $queue;
    }

    public function consumeQueue(string $queue, Closure $closure = null)
    {
        $this->getChannel()->basic_consume(
            $queue,
            $this->getData('consumer_tag', ''),
            $this->getData('no_local', false),
            $this->getData('no_ack', true),
            $this->getData('exclusive', false),
            $this->getData('nowait', false),
            $closure
        );
    }
}
