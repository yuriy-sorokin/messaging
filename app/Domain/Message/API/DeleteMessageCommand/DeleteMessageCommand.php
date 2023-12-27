<?php
declare(strict_types=1);

namespace App\Domain\Message\API\DeleteMessageCommand;

class DeleteMessageCommand
{
    public function __construct(private readonly int $messageId, private readonly int $userId) {}

    public function getMessageId(): int
    {
        return $this->messageId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
