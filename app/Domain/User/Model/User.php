<?php
declare(strict_types=1);

namespace App\Domain\User\Model;

use App\Domain\Email\Model\Email;
use App\Domain\ModelWithIdInterface;
use App\Domain\Security\Model\Password;

class User implements ModelWithIdInterface
{
    private ?int $id = null;
    public function __construct(
        private Email $email,
        private Password $password
    ) {}

    public function &getId(): mixed
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}
