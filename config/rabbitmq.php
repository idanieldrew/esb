<?php

return [
    'host' => 'task_rabbitmq',
    'port' => '5672',
    'user' => 'guest',
    'password' => 'guest',
    'exchange' => 'amq.topic',
    'exchange_type' => 'topic',
    'exchange_passive' => false,
    'exchange_durable' => true,
    'exchange_auto_delete' => false,
    'exchange_internal' => false,
    'exchange_nowait' => false,
    'exchange_properties' => [],
    ];
