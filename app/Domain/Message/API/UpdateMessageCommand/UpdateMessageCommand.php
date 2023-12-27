<?php
declare(strict_types=1);

namespace App\Domain\Message\API\UpdateMessageCommand;

class UpdateMessageCommand
{
    public function __construct(
        private readonly int $id,
        private readonly string $messageText,
        private readonly string $messageCategory
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getMessageText(): string
    {
        return $this->messageText;
    }

    public function getMessageCategory(): string
    {
        return $this->messageCategory;
    }
}
