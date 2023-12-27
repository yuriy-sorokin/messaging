<?php
declare(strict_types=1);

namespace App\Domain\Message\Model;

use App\Domain\ModelWithIdInterface;
use App\Domain\User\Model\User;

class Message implements ModelWithIdInterface
{
    private ?int $id = null;

    public function __construct(
        private readonly User $user,
        private readonly MessageText $messageText,
        private readonly MessageCategory $messageCategory,
        private readonly \DateTimeImmutable $createdAt
    ) {}

    public function &getId(): mixed
    {
        return $this->id;
    }

    public function getMessageCategory(): MessageCategory
    {
        return $this->messageCategory;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getMessageText(): MessageText
    {
        return $this->messageText;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
