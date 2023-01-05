<?php

namespace Idanieldrew\Rabbitmq\Queue\Connectors;

use Idanieldrew\Rabbitmq\Queue\RabbitmqQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitmqConnector implements ConnectorInterface
{
    /**
     * @throws \Exception
     */
    public function connect(array $config)
    {
        $this->connection = new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password']);

        return new RabbitmqQueue($this->connection, $config);
    }
}
