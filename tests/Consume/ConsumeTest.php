<?php

namespace Idanieldrew\Esb\Test\Consume;

use Idanieldrew\Esb\Consume\Consumer;
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

    /**
     * @test
     * @define-env usesExchange
     */
    public function consume_message_with_exchange()
    {
        $queue = 'test_queue';
        $x = function ($message, $res) {
            var_dump($message->body);
        };

        $this->consumerMock->shouldReceive('queueOperation')
            ->once()
            ->andReturn($queue);

        $this->consumerMock->shouldReceive('consumeQueue')
            ->with($queue, null)
            ->once();

        $this->assertEmpty($this->channelMock->callbacks);
        $this->assertTrue($this->consumerMock->consume($queue, $x));
    }

    /**
     * @test
     * @define-env withoutExchange
     */
    public function consume_message_without_exchange()
    {
        $queue = 'test_queue';
        $x = function ($message, $res) {
            var_dump($message->body);
        };

        $this->consumerMock->shouldReceive('consumeQueue')
            ->with($queue, null)
            ->once();

        $this->assertEmpty($this->channelMock->callbacks);
        $this->assertTrue($this->consumerMock->consume($queue, $x));
    }
}
