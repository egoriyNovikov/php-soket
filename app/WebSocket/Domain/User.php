<?php

namespace EgorNovikov\PhpSocket\WebSocket\Domain;

use Ratchet\ConnectionInterface;

class User
{
    private int $connectionId;
    private ConnectionInterface $connection;
    private string $username;
    private \DateTimeImmutable $joinedAt;

    public function __construct(ConnectionInterface $connection, string $username)
    {
        $this->connectionId = $connection->resourceId;
        $this->connection = $connection;
        $this->username = $username;
        $this->joinedAt = new \DateTimeImmutable();
    }

    public function getConnectionId(): int
    {
        return $this->connectionId;
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getJoinedAt(): \DateTimeImmutable
    {
        return $this->joinedAt;
    }

    public function send(array $data): void
    {
        $this->connection->send(json_encode($data));
    }
}
