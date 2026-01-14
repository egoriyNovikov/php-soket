<?php

namespace EgorNovikov\PhpSocket\WebSocket\Router;

use EgorNovikov\PhpSocket\WebSocket\Domain\Message\MessageRouter;
use EgorNovikov\PhpSocket\WebSocket\Connection\ConnectionManager;
use EgorNovikov\PhpSocket\WebSocket\Handler\JoinHandler;
use EgorNovikov\PhpSocket\WebSocket\Handler\ChatHandler;
use EgorNovikov\PhpSocket\WebSocket\Handler\PingHandler;
use EgorNovikov\PhpSocket\WebSocket\Handler\DefaultHandler;

class RouterFactory
{
    /**
     * Создаёт и конфигурирует роутер со всеми хендлерами
     */
    public static function create(ConnectionManager $connectionManager): MessageRouter
    {
        return (new MessageRouter())
            ->registerHandler(new JoinHandler($connectionManager))
            ->registerHandler(new ChatHandler($connectionManager))
            ->registerHandler(new PingHandler())
            ->setFallbackHandler(new DefaultHandler());
    }
}
