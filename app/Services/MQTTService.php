<?php

namespace App\Services;

use App\Libraries\phpMQTT;

class MQTTService
{
    private $server;
    private $port;
    private $username;
    private $password;
    private $client_id;

    public function __construct()
    {
        $this->server = 'test.mosquitto.org';
        $this->port = 1883;
        $this->username = ''; // Biasanya kosong untuk broker publik
        $this->password = ''; // Biasanya kosong untuk broker publik
        $this->client_id = 'laravel_mqtt_client_' . uniqid();
    }

    public function publish($topic, $message)
    {
        $mqtt = new phpMQTT($this->server, $this->port, $this->client_id);

        if ($mqtt->connect(true, NULL, $this->username, $this->password)) {
            $mqtt->publish($topic, $message, 0);
            $mqtt->close();
            return true;
        } else {
            return false;
        }
    }

    public function subscribe($topic, callable $callback)
    {
        $mqtt = new phpMQTT($this->server, $this->port, $this->client_id);

        if ($mqtt->connect(true, NULL, $this->username, $this->password)) {
            $mqtt->subscribe([$topic => ['qos' => 0, 'function' => $callback]]);
            while ($mqtt->proc()) {
                // Keep processing incoming messages
            }
            $mqtt->close();
        } else {
            throw new \Exception('Could not connect to MQTT broker.');
        }
    }
}
