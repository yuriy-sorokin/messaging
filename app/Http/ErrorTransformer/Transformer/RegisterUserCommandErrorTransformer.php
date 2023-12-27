<?php
declare(strict_types=1);

namespace App\Http\ErrorTransformer\Transformer;

use App\Domain\User\API\RegisterUserCommand\Error\RegisterUserCommandError;
use App\Http\ErrorTransformer\ErrorTransformerInterface;

class RegisterUserCommandErrorTransformer implements ErrorTransformerInterface
{
    private const array ERRORS_MAPPING = [
        RegisterUserCommandError::ERROR_INVALID_EMAIL => 'Invalid email',
        RegisterUserCommandError::ERROR_PASSWORD_REQUIREMENTS_NOT_MET => 'Password requirements not met',
        RegisterUserCommandError::ERROR_EMAIL_ALREADY_REGISTERED => 'Email already registered',
    ];

    #[\Override] public function transform(object $error): ?string
    {
        return $this->transformError($error);
    }

    #[\Override] public function getSupportedErrorClass(): string
    {
        return RegisterUserCommandError::class;
    }

    private function transformError(RegisterUserCommandError $error): ?string
    {
        if (true === \array_key_exists($error->getErrors(), static::ERRORS_MAPPING)) {
            return static::ERRORS_MAPPING[$error->getErrors()];
        }

        return null;
    }
}
