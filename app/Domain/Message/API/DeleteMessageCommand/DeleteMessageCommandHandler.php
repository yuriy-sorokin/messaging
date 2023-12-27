<?php
declare(strict_types=1);

namespace App\Domain\Message\API\DeleteMessageCommand;

use App\Domain\Message\Repository\MessageRepository;

class DeleteMessageCommandHandler
{
    public function __construct(private readonly MessageRepository $messageRepository) {}

    public function handle(DeleteMessageCommand $command): DeleteMessageCommandResult
    {
        $result = new DeleteMessageCommandResult();
        $message = $this->messageRepository->find($command->getMessageId());

        if (null === $message || $message->getUser()->getId() !== $command->getUserId()) {
            return $result;
        }

        $this->messageRepository->delete($message);

        return $result;
    }
}
