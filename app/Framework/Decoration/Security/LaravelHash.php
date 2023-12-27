<?php
declare(strict_types=1);

namespace App\Framework\Decoration\Security;

use Illuminate\Support\Facades\Hash;

class LaravelHash implements HashInterface
{
    #[\Override] public function hash(#[\SensitiveParameter] string $value): string
    {
        return Hash::make($value);
    }

    public function validate(#[\SensitiveParameter] string $value, #[\SensitiveParameter] string $hashedValue): bool
    {
        return Hash::check($value, $hashedValue);
    }
}
