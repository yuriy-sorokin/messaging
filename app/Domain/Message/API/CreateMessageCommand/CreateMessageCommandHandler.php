<?php
declare(strict_types=1);

namespace App\Domain\Message\API\CreateMessageCommand;

use App\Domain\Email\Model\Email;
use App\Domain\Message\Model\Message;
use App\Domain\Message\Model\MessageCategory;
use App\Domain\Message\Model\MessageText;
use App\Domain\Message\Repository\MessageRepository;
use App\Domain\Message\Specification\IsMessageTextValidSpecification;
use App\Domain\User\Repository\UserRepository;

class CreateMessageCommandHandler
{
    public function __construct(
        private readonly IsMessageTextValidSpecification $isMessageTextValidSpecification,
        private readonly UserRepository $userRepository,
        private readonly MessageRepository $messageRepository
    ) {}

    public function handle(CreateMessageCommand $command): CreateMessageCommandResult
    {
        if (false === $this->isMessageTextValidSpecification->isSatisfiedBy($command->getMessageText())) {
            return new CreateMessageCommandResult();
        }

        $user = $this->userRepository->findByEmail(new Email($command->getUserEmail()));
        $message = new Message(
            $user,
            new MessageText($command->getMessageText()),
            new MessageCategory($command->getMessageCategory()),
            new \DateTimeImmutable()
        );

        $this->messageRepository->save($message);

        return new CreateMessageCommandResult($message);
    }
}
