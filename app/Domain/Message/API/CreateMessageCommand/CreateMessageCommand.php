<?php
declare(strict_types=1);

namespace App\Domain\Message\API\CreateMessageCommand;

class CreateMessageCommand
{
    public function __construct(
        private readonly string $userEmail,
        private readonly string $messageText,
        private readonly string $messageCategory
    ) {}

    public function getUserEmail(): string
    {
        return $this->userEmail;
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
