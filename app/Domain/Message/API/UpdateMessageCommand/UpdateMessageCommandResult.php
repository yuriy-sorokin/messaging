<?php
declare(strict_types=1);

namespace App\Domain\Message\API\UpdateMessageCommand;

use App\Domain\Message\Model\Message;

class UpdateMessageCommandResult
{
    public function __construct(private readonly ?Message $message = null) {}

    public function getMessage(): ?Message
    {
        return $this->message;
    }
}
