<?php

namespace EgorNovikov\PhpSocket\WebSocket\Domain\Message;

use Ratchet\ConnectionInterface;
use EgorNovikov\PhpSocket\WebSocket\Handler\MessageHandlerInterface;

class MessageRouter
{
    /** @var array<string, MessageHandlerInterface> */
    private array $handlers = [];
    
    private ?MessageHandlerInterface $fallbackHandler = null;

    /**
     * Регистрирует хендлер для определённого типа сообщений
     */
    public function registerHandler(MessageHandlerInterface $handler): self
    {
        $this->handlers[$handler::getType()] = $handler;
        return $this;
    }

    /**
     * Устанавливает fallback-хендлер для необработанных типов
     */
    public function setFallbackHandler(MessageHandlerInterface $handler): self
    {
        $this->fallbackHandler = $handler;
        return $this;
    }

    /**
     * Маршрутизирует сообщение к соответствующему хендлеру
     */
    public function route(Message $message, ConnectionInterface $connection): void
    {
        $type = $message->getType();
        
        $handler = $this->handlers[$type] ?? $this->fallbackHandler;
        
        if ($handler === null) {
            throw new \RuntimeException("No handler registered for message type: {$type}");
        }
        
        $handler->handle($message, $connection);
    }

    /**
     * Проверяет, зарегистрирован ли хендлер для данного типа
     */
    public function hasHandler(string $type): bool
    {
        return isset($this->handlers[$type]);
    }
}
