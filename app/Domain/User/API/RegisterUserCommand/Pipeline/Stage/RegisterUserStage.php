<?php
declare(strict_types=1);

namespace App\Domain\User\API\RegisterUserCommand\Pipeline\Stage;

use App\Domain\Security\Model\Password;
use App\Domain\User\API\RegisterUserCommand\Pipeline\RegisterUserPipelinePayload;
use App\Domain\User\API\RegisterUserCommand\RegisterUserCommandResult;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepository;
use App\Framework\Decoration\Security\HashInterface;

class RegisterUserStage
{
    public function __construct(private readonly UserRepository $userRepository, private readonly HashInterface $hash) {}

    public function handle(RegisterUserPipelinePayload $payload, \Closure $next)
    {
        $hashedPassword = $this->hash->hash($payload->getPassword()->getPassword());

        $this->userRepository->save(new User($payload->getEmail(), new Password($hashedPassword)));

        $payload->setResult(new RegisterUserCommandResult());

        return $next($payload);
    }
}
