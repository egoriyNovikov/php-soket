<?php

use EgorNovikov\PhpSocket\WebSocket\Domain\Message\MessageRouter;
use EgorNovikov\PhpSocket\WebSocket\Handler\MessageHandler;
use EgorNovikov\PhpSocket\WebSocket\Handler\InvalidMessageHandler;
use EgorNovikov\PhpSocket\WebSocket\Handler\PingHandler;
use EgorNovikov\PhpSocket\WebSocket\Handler\DefaultHandler;

$router = new MessageRouter();
$router->addHandler('message', [new MessageHandler(), 'handle']);
$router->addHandler('error', [new InvalidMessageHandler(), 'handle']);
$router->addHandler('ping', [new PingHandler(), 'handle']);
$router->addHandler('pong', [new DefaultHandler(), 'handle']);