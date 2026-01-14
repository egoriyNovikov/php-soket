<?php
namespace EgorNovikov\PhpSocket\WebSocket\Domain\Message;

class Message {
  private string $type;
  private array $payload;

  public function __construct(string $type, array $payload) {
    $this->type = $type;
    $this->payload = $payload;
  }

  public function getType(): string {
      return $this->type;
  }

  public function getPayload(): array {
      return $this->payload;
  }

  public function isInvalid(): bool {
      return $this->type === 'invalid';
  }
}