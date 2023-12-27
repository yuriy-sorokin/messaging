<?php
declare(strict_types=1);

namespace App\Domain\User\API\LoginUserCommand;

class LoginUserCommand
{
    public function __construct(
        private readonly string $email,
        #[\SensitiveParameter]
        private readonly string $password
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
