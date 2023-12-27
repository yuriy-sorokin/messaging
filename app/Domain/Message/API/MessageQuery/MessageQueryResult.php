<?php
declare(strict_types=1);

namespace App\Domain\Message\API\MessageQuery;

use App\Domain\Message\Model\Message;

class MessageQueryResult
{
    private readonly array $messages;

    public function __construct(Message ...$messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return Message[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
