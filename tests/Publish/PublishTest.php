<?php

namespace Idanieldrew\Esb\Test\Publish;

use Exception;
use Idanieldrew\Esb\Publish\Publisher;
use Idanieldrew\Esb\Test\TestCase;
use Mockery;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class PublishTest extends TestCase
{
    private $publishMock;
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

    /** @test */
    public function setup_publish()
    {
        $exception = null;
        $this->connectionMock->shouldReceive('set_close_on_destruct')->with(true)->times(1);

        $this->app->instance(Publisher::class, $this->publishMock);

        $this->publishMock->shouldReceive('connect')->once();

        $this->channelMock->shouldReceive('exchange_declare')->with(
            'custom_exchange',
            'direct',
            false,
            true,
            false,
            false,
            false
        )->times(1);
        $this->channelMock->shouldReceive('queue_declare')->with(
            'test_queue',
            false,
            false,
            false,
            false
        )->times(1);

        try {
            $pub = app(Publisher::class);
            $pub->init();
        } catch (Exception $ex) {
            $exception = $ex;
        }

        $this->assertNull($exception);
    }

    /** @test */
    public function publish_message()
    {
        $this->channelMock->shouldReceive('basic_publish')->with(
            "salam",
            "",
            "test_queue"
        )->once();

        $this->assertTrue($this->publishMock->publish("test_queue", "salam"));
    }
}
