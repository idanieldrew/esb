<?php

namespace Idanieldrew\Esb;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connector
{
    protected AMQPStreamConnection $connection;

    protected AMQPChannel $channel;

    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * Connect to rabbitmq
     *
     * @param array|null $data
     * @return AMQPStreamConnection
     * @throws \Exception
     */
    public function connect(array $data = null)
    {
        $this->connection = new AMQPStreamConnection(
            $this->setData('host', $data),
            $this->setData('port', $data),
            $this->setData('user', $data),
            $this->setData('password', $data),
        );
        $this->channel = $this->connection->channel();

        return $this->connection;
    }

    public function init()
    {
        $this->connect();

        // Set exchange
        $this->channel->exchange_declare(
            $this->getData('exchange'),
            $this->getData('exchange_type'),
            $this->getData('exchange_passive'),
            $this->getData('exchange_durable'),
            $this->getData('exchange_auto_delete'),
            $this->getData('exchange_internal'),
            $this->getData('exchange_nowait')
        );

        //Set queue
        if (!$this->getData('exchange') == null) {
            $this->channel->queue_declare(
                $this->getData('queue'),
                $this->getData('passive', false),
                $this->getData('durable', false),
                $this->getData('exclusive', false),
                $this->getData('nowait', false)
            );
        }
        $this->connection->set_close_on_destruct(true);
    }

    protected function getData(string $data, $default = null)
    {
        return config("esb.$data", $default);
    }

    public static function off(AMQPChannel $channel, AMQPStreamConnection $connection): void
    {
        $channel->close();
        $connection->close();
    }

    /**
     * Return value config in queue or esb config
     *
     * @param string $name
     * @param array|null $config
     * @return mixed
     */
    private function setData(string $name, array $config = null)
    {
        return $config[$name] ?? $this->getData($name);
    }
}
