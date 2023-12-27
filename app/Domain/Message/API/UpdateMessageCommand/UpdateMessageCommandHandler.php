<?php
declare(strict_types=1);

namespace App\Domain\Message\API\UpdateMessageCommand;

use App\Domain\Message\Repository\MessageRepository;
use App\Domain\Message\Specification\IsMessageTextValidSpecification;

class UpdateMessageCommandHandler
{
    public function __construct(
        private readonly IsMessageTextValidSpecification $isMessageTextValidSpecification,
        private readonly MessageRepository $messageRepository
    ) {}

    public function handle(UpdateMessageCommand $command): UpdateMessageCommandResult
    {
        $result = new UpdateMessageCommandResult();

        if (false === $this->isMessageTextValidSpecification->isSatisfiedBy($command->getMessageText())) {
            return $result;
        }

        $message = $this->messageRepository->find($command->getId());

        if (null === $message) {
            return $result;
        }

        $message->getMessageCategory()->setName($command->getMessageCategory());
        $message->getMessageText()->setText($command->getMessageText());

        $this->messageRepository->save($message);

        return new UpdateMessageCommandResult($message);
    }
}
