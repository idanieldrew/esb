<?php

namespace Idanieldrew\Rabbitmq;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connector
{
    private AMQPStreamConnection $connection;

    private AMQPChannel $channel;

    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    public function connect(): void
    {
        $this->connection = new AMQPStreamConnection(
            $this->getData('host'),
            $this->getData('port'),
            $this->getData('user'),
            $this->getData('password'),
        );
        $this->channel = $this->connection->channel();
    }

    public function init()
    {
        $this->connect();
/*        $this->channel->exchange_declare(
            $this->getData('exchange'),
            $this->getData('exchange_type'),
            $this->getData('exchange_passive'),
            $this->getData('exchange_durable'),
            $this->getData('exchange_auto_delete'),
            $this->getData('exchange_internal'),
            $this->getData('exchange_nowait')
        );*/

        $this->channel->queue_declare(
            'hello',
            $this->getData('passive', false),
            $this->getData('durable', false),
            $this->getData('exclusive', false),
            $this->getData('nowait', false)
        );
        return;
//        $this->connection->set_close_on_destruct();
    }

    protected function getData(string $data, $default = null)
    {
        return config("rabbitmq.$data", $default);
    }

    public static function off(AMQPChannel $channel, AMQPStreamConnection $connection): void
    {
        $channel->close();
        $connection->close();
    }
}
