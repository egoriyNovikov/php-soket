<?php

namespace EgorNovikov\PhpSocket\WebSocket\Handler;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\Message\Message;

class InvalidMessageHandler implements MessageHandlerInterface
{
    public function handle(Message $message, ConnectionInterface $connection): void
    {
        echo "Invalid message handler: {$message->getType()}\n";
        
        $connection->send(json_encode([
            'type' => 'error',
            'payload' => ['message' => 'Invalid message format']
        ]));
    }
    
    public static function getType(): string
    {
        return 'error';
    }
}
