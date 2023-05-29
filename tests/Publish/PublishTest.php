<?php

namespace Idanieldrew\Esb\Tests\Publish;

use Exception;
use Idanieldrew\Esb\Message;
use Idanieldrew\Esb\Publish\Publisher;
use Idanieldrew\Esb\Tests\TestCase;
use Mockery;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class PublishTest extends TestCase
{
    private Publisher $publishMock;
    private AMQPChannel $channelMock;
    private AMQPStreamConnection $connectionMock;


    protected function setUp(): void
    {
        parent::setUp();

        $this->channelMock = Mockery::mock(AMQPChannel::class);
        $this->connectionMock = Mockery::mock(AMQPStreamConnection::class);
        $this->publishMock = Mockery::mock(Publisher::class)->makePartial();

        $this->setType(Publisher::class, 'connection', $this->publishMock, $this->connectionMock);
        $this->setType(Publisher::class, 'channel', $this->publishMock, $this->channelMock);
    }

    /**
     * @test
     * @define-env usesExchange
     */
    public function setup_connection_with_special_exchange()
    {
        $this->publishMock->shouldReceive('connectStream')
            ->once()
            ->andReturn($this->connectionMock);

        $this->publishMock->shouldReceive('setUpChannel')
            ->once();

        $this->channelMock->shouldReceive('exchange_declare')
            ->with(
                config('esb.exchange'),
                config('esb.exchange_type'),
                config('esb.passive'),
                config('esb.durable'),
                config('esb.auto_delete'),
            )
            ->once();

        $this->publishMock->connect();
    }

    /**
     * @test
     * @define-env withoutExchange
     */
    public function setup_connection_without_exchange()
    {
        $this->publishMock->shouldReceive('connectStream')
            ->once()
            ->andReturn($this->connectionMock);

        $this->publishMock->shouldReceive('setUpChannel')
            ->once();

        $this->publishMock->connect();
    }

    /** @test */
    public function setup_init()
    {
        $this->publishMock->shouldReceive('connect')
            ->once()
            ->andReturn($this->channelMock);

        $this->connectionMock->shouldReceive('set_close_on_destruct')
            ->with(true)
            ->times(1);

        $this->publishMock->init();
    }

    /** @test */
    public function publish_message()
    {
        $msg = new Message('77');
        $this->channelMock->shouldReceive('basic_publish')->with(
            $msg,
            "test",
            "test_queue"
        )->once();

        $this->publishMock->shouldReceive('queueOperation')->once();

        $ex = null;
        try {
            $this->publishMock->publish("test_queue", $msg,"test");
        } catch (Exception $exception) {
            $ex = $exception;
            throw $ex;
        }
        $this->assertNull($ex);
    }
}
