<?php
ini_set("display_errors",1);
error_reporting(E_ALL & ~E_NOTICE);

require_once dirname(__DIR__) . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.88.137', 5672, 'root', '111111dd', 'firstvhost');
$channel = $connection->channel();
$channel->queue_declare('new_tasks', false, true, false, false);#创建一个永久的queue

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}

$msg = new AMQPMessage(
    $data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)#这边虽然是永久存储但是并不真的保证一定写入到磁盘中
);
$cha
nnel->basic_publish($msg, '', 'hello');

echo ' [x] Sent ', $data, "\n";

$channel->close();
$connection->close();
