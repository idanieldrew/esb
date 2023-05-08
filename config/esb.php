<?php

return [
    'driver' => 'esb',
    'queue' => 'hello',
    'host' => 'task_rabbitmq',
    'port' => '5672',
    'user' => 'guest',
    'password' => 'guest',
    'durable_queue' => true,
    'routing_key' => 'my_routing_key',
    'exchange' => 'direct_exchange',
    'exchange_type' => 'direct',
    'exchange_passive' => false, // topic: false
    'exchange_durable' => false, // topic: false
    'exchange_auto_delete' => false, // topic: false
    'exchange_internal' => false,
    'exchange_nowait' => false,
    'exchange_properties' => [],
    'timeout' => 5,
    'auto_delete' => false,
    'exclusive' => true
];
