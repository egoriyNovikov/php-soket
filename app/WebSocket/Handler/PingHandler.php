<?php

namespace EgorNovikov\PhpSocket\WebSocket\Handler;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\Message\Message;

class PingHandler {
  public function handle(Message $message, ConnectionInterface $connection) {
    echo "Ping handler: {$message->getType()}\n";
  }
}