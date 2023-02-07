<?php

namespace Idanieldrew\Esb\Queue\Connectors;

use Idanieldrew\Esb\Connector;
use Idanieldrew\Esb\Queue\EsbQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;

class EsbConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param array $config
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $connection = (new Connector)->connect($config);

        return new EsbQueue($connection, $config);
    }
}
