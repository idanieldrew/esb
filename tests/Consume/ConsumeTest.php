<?php

namespace Idanieldrew\Esb\Test\Consume;

use Idanieldrew\Esb\Consume\Consumer;
use Idanieldrew\Esb\Message;
use Idanieldrew\Esb\Test\TestCase;
use Mockery;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeTest extends TestCase
{
    private $consumerMock;
    private AMQPChannel $channelMock;
    private AMQPStreamConnection $connectionMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->channelMock = Mockery::mock(AMQPChannel::class);
        $this->connectionMock = Mockery::mock(AMQPStreamConnection::class);
        $this->consumerMock = Mockery::mock(Consumer::class)->makePartial();

        $this->setType(Consumer::class, 'connection', $this->consumerMock, $this->connectionMock);
        $this->setType(Consumer::class, 'channel', $this->consumerMock, $this->channelMock);
    }

    /** @test */
    public function consume_message()
    {
        $this->app->instance(Consumer::class, $this->consumerMock);
        $x = function ($message, $res) {
            var_dump($message->body);
        };

        $this->channelMock->shouldReceive('queue_declare')->with(
            "test_queue",
            false,
            false,
            true,
            false
        )->times(1)->andReturn('test_queue');

        $this->channelMock->shouldReceive('queue_bind')->with(
            null,
            'topic_exchange',
            'my_routing_key'
        )->times(1);

        $this->channelMock->shouldReceive('basic_consume')->with(
            "test_queue",
            "",
            false,
            true,
            false,
            false,
            $x
        )->times(1);

        $this->assertTrue($this->consumerMock->consume("test_queue", $x));
    }
}
