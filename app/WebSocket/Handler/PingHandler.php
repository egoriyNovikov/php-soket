<?php

namespace EgorNovikov\PhpSocket\WebSocket\Handler;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\Message\Message;

class PingHandler implements MessageHandlerInterface
{
    public function handle(Message $message, ConnectionInterface $connection): void
    {
        $connection->send(json_encode([
            'type' => 'pong',
            'payload' => $message->getPayload()
        ]));
    }
    
    public static function getType(): string
    {
        return 'ping';
    }
}
