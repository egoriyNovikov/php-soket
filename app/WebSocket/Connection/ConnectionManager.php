<?php

namespace EgorNovikov\PhpSocket\WebSocket\Connection;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\User;

class ConnectionManager
{
    /** @var array<int, ConnectionInterface> */
    private array $connections = [];
    
    /** @var array<int, User> */
    private array $users = [];
    
    /** @var array<string, array{type: string, username: string, text: string, time: string}> */
    private array $messageHistory = [];

    public function addConnection(ConnectionInterface $connection): int
    {
        $this->connections[$connection->resourceId] = $connection;
        return $connection->resourceId;
    }

    public function removeConnection(ConnectionInterface $connection): ?User
    {
        $user = $this->users[$connection->resourceId] ?? null;
        
        unset($this->connections[$connection->resourceId]);
        unset($this->users[$connection->resourceId]);
        
        return $user;
    }

    public function registerUser(ConnectionInterface $connection, string $username): User
    {
        $user = new User($connection, $username);
        $this->users[$connection->resourceId] = $user;
        return $user;
    }

    public function getUser(ConnectionInterface $connection): ?User
    {
        return $this->users[$connection->resourceId] ?? null;
    }

    public function isUserRegistered(ConnectionInterface $connection): bool
    {
        return isset($this->users[$connection->resourceId]);
    }

    public function isUsernameTaken(string $username): bool
    {
        foreach ($this->users as $user) {
            if (strcasecmp($user->getUsername(), $username) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array<int, ConnectionInterface>
     */
    public function getConnections(): array
    {
        return $this->connections;
    }

    /**
     * @return array<int, User>
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    public function getUserCount(): int
    {
        return count($this->users);
    }

    /**
     * Отправляет сообщение всем пользователям
     */
    public function broadcast(array $data, ?ConnectionInterface $except = null): void
    {
        foreach ($this->users as $user) {
            if ($except && $user->getConnectionId() === $except->resourceId) {
                continue;
            }
            $user->send($data);
        }
    }

    /**
     * Отправляет сообщение всем, включая отправителя
     */
    public function broadcastToAll(array $data): void
    {
        foreach ($this->users as $user) {
            $user->send($data);
        }
    }

    /**
     * Добавляет сообщение в историю
     */
    public function addToHistory(string $username, string $text, string $type = 'chat'): void
    {
        $this->messageHistory[] = [
            'type' => $type,
            'username' => $username,
            'text' => $text,
            'time' => date('H:i:s')
        ];
        
        // Храним последние 100 сообщений
        if (count($this->messageHistory) > 100) {
            array_shift($this->messageHistory);
        }
    }

    /**
     * Возвращает историю сообщений
     */
    public function getHistory(): array
    {
        return $this->messageHistory;
    }

    /**
     * Возвращает список имён пользователей онлайн
     */
    public function getOnlineUsernames(): array
    {
        return array_map(
            fn(User $user) => $user->getUsername(),
            array_values($this->users)
        );
    }
}
