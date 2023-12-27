<?php
declare(strict_types=1);

namespace App\Framework\Decoration\Security;

interface HashInterface
{
    public function hash(#[\SensitiveParameter] string $value): string;

    public function validate(#[\SensitiveParameter] string $value, #[\SensitiveParameter] string $hashedValue): bool;
}
