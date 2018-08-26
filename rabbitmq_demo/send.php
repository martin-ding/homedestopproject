<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.88.137', 5672, 'root', '111111dd', 'firstvhost');
$channel = $connection->channel();
$channel->queue_declare('hello1', false, false, false, false);
$msg = new AMQPMessage("oewkalsdjalskj");
$channel->basic_publish($msg, "", "hello1");

$channel->close();
$connection->close();

echo 'wow';
