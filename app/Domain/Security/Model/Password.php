<?php
declare(strict_types=1);

namespace App\Domain\Security\Model;

class Password
{
    public function __construct(#[\SensitiveParameter] private readonly string $password) {}

    public function getPassword(): string
    {
        return $this->password;
    }
}
