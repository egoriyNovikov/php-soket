<?php

namespace EgorNovikov\PhpSocket\WebSocket\Handler;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\Message\Message;

interface MessageHandlerInterface
{
    /**
     * Обрабатывает входящее сообщение
     */
    public function handle(Message $message, ConnectionInterface $connection): void;
    
    /**
     * Возвращает тип сообщения, который обрабатывает данный хендлер
     */
    public static function getType(): string;
}
