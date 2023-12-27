<?php
declare(strict_types=1);

namespace App\Domain\Security\Specification\Password;

use App\Domain\Security\Model\Password;
use App\Framework\Decoration\Security\HashInterface;

class AreEqualSpecification
{
    public function __construct(private readonly HashInterface $hash) {}

    public function isSatisfiedBy(Password $passwordToVerify, Password $originalPassword): bool
    {
        return $this->hash->validate($passwordToVerify->getPassword(), $originalPassword->getPassword());
    }
}
