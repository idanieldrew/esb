<?php

return [
    'host' => 'task_rabbitmq',
    'port' => '5672',
    'user' => 'guest',
    'password' => 'guest',
    'queue' => 'test_queue',
    'exchange' => 'custom_exchange',
    'exchange_type' => 'direct',
    'exchange_passive' => false,
    'exchange_durable' => true,
    'exchange_auto_delete' => false,
    'exchange_internal' => false,
    'exchange_nowait' => false,
    'exchange_properties' => [],
];
