<?php
declare(strict_types=1);

namespace App\Domain\User\API\RegisterUserCommand\Error;

class RegisterUserCommandError
{
    public const ERROR_INVALID_EMAIL = 1;
    public const ERROR_PASSWORD_REQUIREMENTS_NOT_MET = 2;
    public const ERROR_EMAIL_ALREADY_REGISTERED = 4;

    public static function invalidEmail(): self
    {
        return new self(static::ERROR_INVALID_EMAIL);
    }

    public static function passwordRequirementsNotMet(): self
    {
        return new self(static::ERROR_PASSWORD_REQUIREMENTS_NOT_MET);
    }

    public static function emailAlreadyRegistered(): self
    {
        return new self(static::ERROR_EMAIL_ALREADY_REGISTERED);
    }

    private function __construct(private readonly int $errors) {}

    public function getErrors(): int
    {
        return $this->errors;
    }
}
