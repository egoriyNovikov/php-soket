<?php 

namespace EgorNovikov\PhpSocket\WebSocket\Handler;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\Message\Message;

class InvalidMessageHandler {
  public function handle(Message $message, ConnectionInterface $connection) {
    echo "Invalid message handler: {$message->getType()}\n";
  }
}