<?php

namespace Idanieldrew\Esb\Consume;

use Exception;
use Idanieldrew\Esb\Connector;

class Consumer extends Connector
{
    public function consume($queue)
    {
        $queue = $queue ?? $this->getData('queue');

        try {
            $callback = function ($msg) {
                echo ' [x] Received ', $msg->body;
            };
            $this->getChannel()->basic_consume(
                $queue,
                '',
                false,
                true,
                false,
                false,
                $callback
            );

            while (count($this->getChannel()->callbacks)) {
                $this->getChannel()->wait(null, false, 1);
            }
        } catch (Exception $e) {
            return true;
//            throw $e;
        }
    }
}
