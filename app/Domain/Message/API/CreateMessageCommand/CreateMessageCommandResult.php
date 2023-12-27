<?php
declare(strict_types=1);

namespace App\Domain\Message\API\CreateMessageCommand;

use App\Domain\Message\Model\Message;

class CreateMessageCommandResult
{
    public function __construct(private readonly ?Message $message = null) {
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }
}
