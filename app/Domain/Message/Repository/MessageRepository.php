<?php
declare(strict_types=1);

namespace App\Domain\Message\Repository;

use App\Domain\Message\Model\Message;
use App\Framework\Decoration\Database\DatabaseInterface;

class MessageRepository
{
    public function __construct(private readonly DatabaseInterface $database) {}
    public function save(Message $message): void
    {
        $this->database->save($message);
    }

    public function find(int $id): ?Message
    {
        return $this->database->findOne(Message::class, ['id' => $id]);
    }

    public function delete(Message $message): void
    {
        $this->database->delete($message);
    }

    /**
     * @param callable $criteria
     * @return Message[]
     */
    public function findBy(callable $criteria): array
    {
        return $this->database->findBy(Message::class, $criteria);
    }
}
