<?php
declare(strict_types=1);

namespace App\Domain\User\API\RegisterUserCommand;

use App\Domain\Email\Model\Email;
use App\Domain\Security\Model\Password;
use App\Domain\User\API\RegisterUserCommand\Error\RegisterUserCommandError;
use App\Domain\User\API\RegisterUserCommand\Pipeline\RegisterUserPipelinePayload;
use App\Domain\User\API\RegisterUserCommand\Pipeline\Stage\CheckEmailIsAlreadyRegisteredStage;
use App\Domain\User\API\RegisterUserCommand\Pipeline\Stage\CheckPasswordRequirementsStage;
use App\Domain\User\API\RegisterUserCommand\Pipeline\Stage\RegisterUserStage;
use Illuminate\Pipeline\Pipeline;

class RegisterUserCommandHandler
{
    public function __construct(private readonly Pipeline $pipeline) {}

    public function handle(RegisterUserCommand $command): RegisterUserCommandResult
    {
        try {
            $email = new Email($command->getEmail());
        } catch (\Throwable) {
            return new RegisterUserCommandResult(RegisterUserCommandError::invalidEmail());
        }

        $pipelinePayload = new RegisterUserPipelinePayload($email, new Password($command->getPassword()));

        $this->pipeline
            ->send($pipelinePayload)
            ->through([
                CheckPasswordRequirementsStage::class,
                CheckEmailIsAlreadyRegisteredStage::class,
                RegisterUserStage::class,
            ])
            ->thenReturn();

        return $pipelinePayload->getResult();
    }
}
