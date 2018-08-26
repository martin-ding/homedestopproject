<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('192.168.88.137', 5672, 'root', '111111dd', 'firstvhost');
$channel = $connection->channel();
// $channel->queue_declare('hello', false, false, false, false);
// $channel->queue_declare('hello', false, false, false, false);

$callback = function ($msg) {
  echo ' [x] Received ', $msg->body, "\n";
};

$channel->basic_consume('hello1', '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
