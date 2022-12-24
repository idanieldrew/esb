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
            "host",
            "port",
            "user",
            "password",
            "/"
        );
        $this->channel = $this->connection->channel();
    }

    public function init()
    {
        $this->connect();
        $this->channel->exchange_declare(
            "exchange",
            "type",
            "passive",
            "durable",
            "auto_delete",
            "internal",
            "nowait",
            "arguments",
            "ticket"
        );

        $this->channel->queue_declare(
            "queue",
            "passive",
            "durable",
            "exclusive",
            "auto_delete",
            "nowait",
            "arguments",
            "ticket"
        );
        $this->connection->set_close_on_destruct();
    }

    public static function off(AMQPChannel $channel, AMQPStreamConnection $connection): void
    {
        $channel->close();
        $connection->close();
    }
}
