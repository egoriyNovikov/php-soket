<?php

namespace EgorNovikov\PhpSocket\WebSocket\Handler;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Domain\Message\Message;
use EgorNovikov\PhpSocket\WebSocket\Connection\ConnectionManager;

class JoinHandler implements MessageHandlerInterface
{
    private ConnectionManager $connectionManager;

    public function __construct(ConnectionManager $connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }

    public function handle(Message $message, ConnectionInterface $connection): void
    {
        $payload = $message->getPayload();
        $username = trim($payload['username'] ?? '');

        // Валидация имени
        if (empty($username)) {
            $connection->send(json_encode([
                'type' => 'error',
                'payload' => ['message' => 'Имя пользователя не может быть пустым']
            ]));
            return;
        }

        if (strlen($username) < 2 || strlen($username) > 20) {
            $connection->send(json_encode([
                'type' => 'error',
                'payload' => ['message' => 'Имя должно быть от 2 до 20 символов']
            ]));
            return;
        }

        // Проверка, не зарегистрирован ли уже
        if ($this->connectionManager->isUserRegistered($connection)) {
            $connection->send(json_encode([
                'type' => 'error',
                'payload' => ['message' => 'Вы уже в чате']
            ]));
            return;
        }

        // Проверка уникальности имени
        if ($this->connectionManager->isUsernameTaken($username)) {
            $connection->send(json_encode([
                'type' => 'error',
                'payload' => ['message' => 'Это имя уже занято']
            ]));
            return;
        }

        // Регистрируем пользователя
        $user = $this->connectionManager->registerUser($connection, $username);

        // Отправляем подтверждение пользователю
        $connection->send(json_encode([
            'type' => 'joined',
            'payload' => [
                'username' => $username,
                'users' => $this->connectionManager->getOnlineUsernames(),
                'history' => $this->connectionManager->getHistory()
            ]
        ]));

        // Уведомляем остальных о новом пользователе
        $this->connectionManager->broadcast([
            'type' => 'user_joined',
            'payload' => [
                'username' => $username,
                'users' => $this->connectionManager->getOnlineUsernames(),
                'time' => date('H:i:s')
            ]
        ], $connection);

        // Добавляем в историю
        $this->connectionManager->addToHistory($username, 'присоединился к чату', 'system');

        echo "User joined: {$username}\n";
    }

    public static function getType(): string
    {
        return 'join';
    }
}
