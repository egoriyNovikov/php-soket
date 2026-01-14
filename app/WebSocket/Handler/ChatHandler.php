<?php

namespace EgorNovikov\PhpSocket\WebSocket\Handler;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\Message\Message;
use EgorNovikov\PhpSocket\WebSocket\Connection\ConnectionManager;

class ChatHandler implements MessageHandlerInterface
{
    private ConnectionManager $connectionManager;

    public function __construct(ConnectionManager $connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }

    public function handle(Message $message, ConnectionInterface $connection): void
    {
        // Проверяем, зарегистрирован ли пользователь
        $user = $this->connectionManager->getUser($connection);
        
        if ($user === null) {
            $connection->send(json_encode([
                'type' => 'error',
                'payload' => ['message' => 'Сначала войдите в чат']
            ]));
            return;
        }

        $payload = $message->getPayload();
        $text = trim($payload['text'] ?? '');

        if (empty($text)) {
            return; // Игнорируем пустые сообщения
        }

        // Ограничиваем длину сообщения
        if (strlen($text) > 1000) {
            $text = substr($text, 0, 1000) . '...';
        }

        $username = $user->getUsername();
        $time = date('H:i:s');

        // Добавляем в историю
        $this->connectionManager->addToHistory($username, $text);

        // Отправляем всем пользователям
        $this->connectionManager->broadcastToAll([
            'type' => 'chat',
            'payload' => [
                'username' => $username,
                'text' => $text,
                'time' => $time
            ]
        ]);

        echo "[{$time}] {$username}: {$text}\n";
    }

    public static function getType(): string
    {
        return 'chat';
    }
}
