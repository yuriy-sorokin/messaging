<?php
declare(strict_types=1);

namespace App\Domain\User\API\LoginUserCommand;

use App\Domain\Email\Model\Email;
use App\Domain\Security\Model\Password;
use App\Domain\Security\Specification\Password\AreEqualSpecification;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepository;

class LoginUserCommandHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly AreEqualSpecification $arePasswordsEqualSpecification
    ) {}

    public function handle(LoginUserCommand $command): LoginUserCommandResult
    {
        $user = $this->userRepository->findByEmail(new Email($command->getEmail()));

        if (false === $user instanceof User) {
            return new LoginUserCommandResult();
        }

        if (false === $this->arePasswordsEqualSpecification->isSatisfiedBy(new Password($command->getPassword()), $user->getPassword())) {
            return new LoginUserCommandResult();
        }

        return new LoginUserCommandResult($user);
    }
}
