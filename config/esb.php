<?php

return [
    'driver' => 'esb',
    'queue' => 'hello1',
    'host' => 'task_rabbitmq',
    'port' => '5672',
    'user' => 'guest',
    'password' => 'guest',
    'durable_queue' => true,
    'routing_key' => 'my_routing_key',
    'exchange' => 'topic_exchange',
    'exchange_type' => 'topic',
    'exchange_passive' => false, // topic: false
    'exchange_durable' => false, // topic: false
    'exchange_auto_delete' => false, // topic: false
    'exchange_internal' => false,
    'exchange_nowait' => false,
    'exchange_properties' => [],
    'timeout' => 5,
    'auto_delete' => false,
    'exclusive' => true,
    'passive' => false,
    'durable' => false,
];
