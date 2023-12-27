<?php
declare(strict_types=1);

namespace App\Framework\Decoration\DatabaseMapping\Domain\User\Model;

use App\Domain\Email\Model\Email;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class EmailCast implements CastsAttributes
{
    #[\Override] public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return new Email($value);
    }

    #[\Override] public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if (false === $value instanceof Email) {
            throw new \InvalidArgumentException('Invalid model passed');
        }

        return $value->getEmail();
    }
}
