<?php
declare(strict_types=1);

namespace App\Domain\User\API\RegisterUserCommand\Pipeline\Stage;

use App\Domain\User\API\RegisterUserCommand\Error\RegisterUserCommandError;
use App\Domain\User\API\RegisterUserCommand\Pipeline\RegisterUserPipelinePayload;
use App\Domain\User\API\RegisterUserCommand\RegisterUserCommandResult;

class CheckPasswordRequirementsStage
{
    private const MIN_PASSWORD_LENGTH = 9;

    public function handle(RegisterUserPipelinePayload $payload, \Closure $next)
    {
        if (static::MIN_PASSWORD_LENGTH > \strlen($payload->getPassword()->getPassword())) {
            $payload->setResult(new RegisterUserCommandResult(RegisterUserCommandError::passwordRequirementsNotMet()));

            return;
        }

        return $next($payload);
    }
}
