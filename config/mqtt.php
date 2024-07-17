<?php

return [
    'host' => env('MQTT_HOST', 'test.mosquitto.org'),
    'port' => env('MQTT_PORT', 1883),
    'client_id' => env('MQTT_CLIENT_ID', 'LaravelClient'),
    'username' => env('MQTT_USERNAME', null),
    'password' => env('MQTT_PASSWORD', null),
    'clean_session' => env('MQTT_CLEAN_SESSION', true),
    'qos' => env('MQTT_QOS', 0),
    'retain' => env('MQTT_RETAIN', false),
];
