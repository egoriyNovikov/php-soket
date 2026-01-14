<?php

namespace EgorNovikov\PhpSocket\WebSocket\Connection;

use Ratchet\ConnectionInterface;

class ConnectionManager {
  private $connections = [];

  public function addConnection(ConnectionInterface $connection) {
    $this->connections[$connection->resourceId] = $connection;
    return $connection->resourceId;
  }

  public function removeConnection(ConnectionInterface $connection) {
    unset($this->connections[$connection->resourceId]);
  }

  public function getConnections() {
    return $this->connections;
  }
}