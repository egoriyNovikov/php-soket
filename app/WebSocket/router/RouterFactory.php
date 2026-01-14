<?php

namespace EgorNovikov\PhpSocket\WebSocket\Router;

use EgorNovikov\PhpSocket\WebSocket\Domain\Message\MessageRouter;
use EgorNovikov\PhpSocket\WebSocket\Handler\MessageHandler;
use EgorNovikov\PhpSocket\WebSocket\Handler\InvalidMessageHandler;
use EgorNovikov\PhpSocket\WebSocket\Handler\PingHandler;
use EgorNovikov\PhpSocket\WebSocket\Handler\DefaultHandler;

class RouterFactory
{
    /**
     * Создаёт и конфигурирует роутер со всеми хендлерами
     */
    public static function create(): MessageRouter
    {
        return (new MessageRouter())
            ->registerHandler(new MessageHandler())
            ->registerHandler(new InvalidMessageHandler())
            ->registerHandler(new PingHandler())
            ->setFallbackHandler(new DefaultHandler());
    }
}
