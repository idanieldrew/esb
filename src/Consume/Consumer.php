<?php

namespace Idanieldrew\Rabbitmq\Consume;

use Exception;
use Idanieldrew\Rabbitmq\Connector;
use Illuminate\Support\Facades\Log;

class Consumer extends Connector
{
    public function consume($queue)
    {
        try {
            $callback = function ($msg) {
                Log::info(22);
                echo ' [x] Received ', $msg->body, "\n";
            };
            $this->getChannel()->basic_consume(
                'hello',
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
