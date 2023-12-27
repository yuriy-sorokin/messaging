<?php
declare(strict_types=1);

namespace App\Domain\Email\Model;

class Email
{
    private readonly string $email;

    public function __construct(string $email)
    {
        $this->email = \filter_var($email, FILTER_VALIDATE_EMAIL);

        if (false === $this->email) {
            throw new \InvalidArgumentException('Invalid email');
        }
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
