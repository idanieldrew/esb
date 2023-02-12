<?php

namespace Idanieldrew\Esb\Queue;

use Idanieldrew\Esb\Queue\Jobs\EsbJob;
use Illuminate\Contracts\Queue\Queue as Contract;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class EsbQueue extends Queue implements Contract
{
    protected $channel;

    protected string $queue;

    /**
     * Get queue
     *
     * @param string|null $default
     * @return string
     */
    public function getQueue(string $default = null): string
    {
        return $default ?? $this->queue;
    }

    public function __construct(protected AMQPStreamConnection $connection, protected array $config)
    {
        $this->queue = $config['queue'];
        $this->channel = $this->connection->channel();
    }

    public function size($queue = null)
    {
        //
    }

    /**
     * Push a new job onto the queue.
     *
     * @param string|object $job
     * @param mixed $data
     * @param string|null $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        $queue = $this->getQueue($queue);

        return $this->enqueueUsing(
            $job,
            $this->createPayload($job, $queue, $data),
            $queue,
            null,
            function ($payload, $queue) {
                return $this->pushRaw($payload, $queue);
            }
        );
    }

    public function pushRaw($payload, $queue = null, array $options = [])
    {
        $message = new AMQPMessage($payload, [
            'Content-Type' => 'application/json',
            'delivery_mode' => 2,
        ]);

        $this->channel->queue_declare(
            $queue,
            false,
            $this->config['durable_queue'],
            false,
            false
        );

        $this->channel->basic_publish($message, '', $queue);
        return true;
    }

    public function later($delay, $job, $data = '', $queue = null)
    {
        return $this->pushRaw($data, $queue, [$delay]);
    }

    public function pop($queue = null)
    {
        try {
            $queue = $this->getQueue($queue);

            $this->channel->queue_declare(
                $queue,
                false,
                $this->config['durable_queue'],
                false,
                false
            );

            $message = $this->channel->basic_get($queue);

            if ($message instanceof AMQPMessage) {
                return new EsbJob($this->container, $this, $this->connection->channel(), $queue, $message);
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
        return null;
    }

    public function clear($queue)
    {
        Log::alert('clear');
    }

    public function bulk($jobs, $data = '', $queue = null)
    {
        parent::bulk($jobs, $data, $queue); // TODO: Change the autogenerated stub
    }

    private function declareQueue($name)
    {
        /* $this->connection->channel()->exchange_declare(
             $this->config['exchange'],
             $this->config['exchange_type'],
             $this->config['exchange_passive'],
             $this->config['exchange_durable'],
             $this->config['exchange_auto_delete'],
             $this->config['exchange_internal'],
             $this->config['exchange_nowait']
         );*/

        $this->connection->channel()->queue_declare(
            $this->config['exchange'],
            $this->config['passive'] ?? false,
            $this->config['durable'] ?? false,
            $this->config['exclusive'] ?? false,
            $this->config['nowait'] ?? false
        );
    }

    public function release($delay, $job, $data, $queue, $attempts = 0)
    {
        dd('4444444444');
    }

    public function ack(EsbJob $job)
    {
        $this->channel->basic_ack($job->getMessages()->getDeliveryTag());
    }
}
