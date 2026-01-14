<?php
namespace EgorNovikov\PhpSocket\WebSocket\Domain\Message;

class MessageFactory
{
    public static function createFromString(string $raw): Message
    {
        if (trim($raw) === '') {
            return new Message('invalid', [
                'reason' => 'empty_message'
            ]);
        }

        $data = json_decode($raw, true);

        if (!is_array($data)) {
            return new Message('invalid', [
                'reason' => 'invalid_json'
            ]);
        }

        if (
            !isset($data['type']) ||
            !is_string($data['type']) ||
            trim($data['type']) === ''
        ) {
            return new Message('invalid', [
                'reason' => 'missing_or_invalid_type'
            ]);
        }

        $payload = [];

        if (isset($data['payload'])) {
            if (!is_array($data['payload'])) {
                return new Message('invalid', [
                    'reason' => 'invalid_payload'
                ]);
            }

            $payload = $data['payload'];
        }

        return new Message($data['type'], $payload);
    }
}
