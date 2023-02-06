<?php

namespace Idanieldrew\Esb\Queue\Connectors;

use Idanieldrew\Esb\Connector;
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
        $connection = (new Connector)->connect($config);

        return new EsbQueue($connection, $config);
    }
}
