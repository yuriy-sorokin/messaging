<?php
declare(strict_types=1);

namespace App\Domain\User\API\LoginUserCommand;

use App\Domain\User\Model\User;

class LoginUserCommandResult
{
    public function __construct(private readonly ?User $user = null) {}

    public function getUser(): ?User
    {
        return $this->user;
    }
}
