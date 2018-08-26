<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.88.137', 5672, 'root', '111111dd', 'firstvhost');
$channel = $connection->channel();
$channel->queue_declare('hello', false, true, false, false);

$callback = function($msg){
	echo ' [x] Received ', $msg->body, "\n";
	sleep(substr_count($msg->body, '.'));
	echo " [x] Done\n";
	$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']); #需要等到ack
};

$channel->basic_qos(null, 1, null); #默认情况下queue

$channel->basic_consume('hello', '', false, true, false, false, $callback);
while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
