<?php
declare(strict_types=1);

namespace App\Domain\User\API\RegisterUserCommand\Pipeline\Stage;

use App\Domain\User\API\RegisterUserCommand\Error\RegisterUserCommandError;
use App\Domain\User\API\RegisterUserCommand\Pipeline\RegisterUserPipelinePayload;
use App\Domain\User\API\RegisterUserCommand\RegisterUserCommandResult;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepository;

class CheckEmailIsAlreadyRegisteredStage
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function handle(RegisterUserPipelinePayload $payload, \Closure $next)
    {
        var_export($this->userRepository->findByEmail($payload->getEmail()) instanceof User);
        if (true === $this->userRepository->findByEmail($payload->getEmail()) instanceof User) {
            $payload->setResult(new RegisterUserCommandResult(RegisterUserCommandError::emailAlreadyRegistered()));

            return;
        }

        return $next($payload);
    }
}
