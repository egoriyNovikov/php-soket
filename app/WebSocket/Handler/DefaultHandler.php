<?php

namespace EgorNovikov\PhpSocket\WebSocket\Handler;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\Message\Message;

class DefaultHandler implements MessageHandlerInterface
{
    public function handle(Message $message, ConnectionInterface $connection): void
    {
        echo "Default handler (unhandled type): {$message->getType()}\n";
        
        $connection->send(json_encode([
            'type' => 'unknown',
            'payload' => ['original_type' => $message->getType()]
        ]));
    }
    
    public static function getType(): string
    {
        return 'default';
    }
}
