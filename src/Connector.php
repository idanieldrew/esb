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
        $this->connection = $this->connectStream($data);

        $this->setUpChannel();
        if ($this->getData('exchange') !== null) {
            $this->getChannel()->exchange_declare(
                $this->getData('exchange'),
                $this->getData('exchange_type'),
                $this->getData('passive'),
                $this->getData('durable'),
                $this->getData('auto_delete')
            );
        }

        return $this->connection;
    }

    public function setUpChannel()
    {
        $this->channel = $this->connection->channel();
    }

    public function init()
    {
        $this->connect();

        $this->connection->set_close_on_destruct(true);
    }

    public function connectStream($data = null)
    {
        return new AMQPStreamConnection(
            $this->setData('host', $data),
            $this->setData('port', $data),
            $this->setData('user', $data),
            $this->setData('password', $data),
        );
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
