<?php

namespace EgorNovikov\PhpSocket\WebSocket\Domain\Message;

use Ratchet\ConnectionInterface;

class MessageRouter {
  private $handlers = [];

  public function addHandler(string $type, callable $handler) {
    $this->handlers[$type] = $handler;
  }

  public function route(Message $message, ConnectionInterface $connection) {
    $type = $message->getType();
    if(isset($this->handlers[$type])) {
      $this->handlers[$type]($message, $connection);
    }
  }
}