<?php

namespace EgorNovikov\PhpSocket\WebSocket\Handler;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\Message\Message;

class MessageHandler implements MessageHandlerInterface
{
    public function handle(Message $message, ConnectionInterface $connection): void
    {
        echo "Message handler: {$message->getType()}\n";
    }
    
    public static function getType(): string
    {
        return 'message';
    }
}
