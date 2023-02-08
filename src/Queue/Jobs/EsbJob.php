<?php

namespace Idanieldrew\Esb\Queue\Jobs;

use Idanieldrew\Esb\Queue\EsbQueue;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\Job as Contract;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class EsbJob extends Job implements Contract
{
    protected $container;

    protected $queue;
    protected $message;
    protected $channel;
    protected $connection;

    public function __construct(Container $container, EsbQueue $connection, AMQPChannel $channel, string $queue, AMQPMessage $message)
    {
        $this->queue = $queue;
        $this->channel = $channel;
        $this->message = $message;
        $this->container = $container;
        $this->connection = $connection;
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        Log::alert("getrawbody");

        return $this->message->body;
    }

    /**
     * Delete the job from the queue.
     *
     * @return void
     */
    public function delete()
    {
        Log::alert("delete");

        parent::delete();

        if (!$this->failed) {
            $this->connection->ack($this);
        }
    }

    /**
     * Get queue name
     *
     * @return string
     */
    public function getQueue()
    {
        Log::alert("getqueue");

        return $this->queue;
    }

    /**
     * Release the job back into the queue.
     *
     * @param int $delay
     *
     * @return void
     */
    /* public function release($delay = 0)
     {
         parent::release();
         Log::alert("release");
         $this->delete();

         $body = json_decode($this->message->body, true);

         if (!is_array($body)) {
             return;
         }

         $attempts = $this->attempts();

         // write attempts to body
         $body['custom_meta_data']['attempts'] = $attempts + 1;

         $data = $this->constructCustomMessage($body);

         if ($delay > 0) {
             $this->connection->later($delay, null, $data, $this->getQueue());
         } else {
             $this->connection->push(null, $data, $this->getQueue());
         }
     }*/

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        $body = json_decode($this->message->body, true);

        return isset($body['custom_meta_data']['attempts']) ? (int)$body['custom_meta_data']['attempts'] : 0;
    }

    /**
     * Json Decode the Message and return the body
     *
     * @return array $message
     */
    public function toArray()
    {
        return json_decode($this->message->body, true);
    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
        Log::alert('getJobId');
        return 'def';
    }

    /**
     * Get the Body as a String to be pushed to RabbitMQ
     *
     * @param array $body Data to be pushed
     * @return string $data     json_encoded-ed $body
     */
    public function constructCustomMessage(array $body)
    {
        return json_encode($body);
    }

    public function getMessages()
    {
        return $this->message;
    }
}
