<?php
declare(strict_types=1);

namespace App\Domain\User\API\RegisterUserCommand;

use App\Domain\User\API\RegisterUserCommand\Error\RegisterUserCommandError;

class RegisterUserCommandResult
{
    public function __construct(private readonly ?RegisterUserCommandError $error = null) {}

    public function getError(): ?RegisterUserCommandError
    {
        return $this->error;
    }
}
