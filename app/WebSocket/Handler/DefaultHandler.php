<?php

namespace EgorNovikov\PhpSocket\WebSocket\Handler;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\Message\Message;

class DefaultHandler {
  public function handle(Message $message, ConnectionInterface $connection) {
    echo "Default handler: {$message->getType()}\n";
  }
}