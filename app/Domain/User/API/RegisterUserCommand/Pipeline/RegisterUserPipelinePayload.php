<?php
declare(strict_types=1);

namespace App\Domain\User\API\RegisterUserCommand\Pipeline;

use App\Domain\Email\Model\Email;
use App\Domain\Security\Model\Password;
use App\Domain\User\API\RegisterUserCommand\RegisterUserCommandResult;

class RegisterUserPipelinePayload
{
    private ?RegisterUserCommandResult $result;

    public function __construct(private readonly Email $email, private readonly Password $password) {}

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function setResult(RegisterUserCommandResult $result): void
    {
        $this->result = $result;
    }

    public function getResult(): ?RegisterUserCommandResult
    {
        return $this->result;
    }
}
