<?php

namespace Idanieldrew\Esb\Queue\Connectors;

use Idanieldrew\Esb\Queue\EsbQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class EsbConnector implements ConnectorInterface
{
    /**
     * @throws \Exception
     */
    public function connect(array $config)
    {
        $this->connection = new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password']);

        return new EsbQueue($this->connection, $config);
    }
}
