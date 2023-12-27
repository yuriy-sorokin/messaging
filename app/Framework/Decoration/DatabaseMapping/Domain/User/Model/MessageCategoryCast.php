<?php
declare(strict_types=1);

namespace App\Framework\Decoration\DatabaseMapping\Domain\User\Model;

use App\Domain\Message\Model\MessageCategory;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MessageCategoryCast implements CastsAttributes
{
    #[\Override] public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return new MessageCategory($value);
    }

    #[\Override] public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if (false === $value instanceof MessageCategory) {
            throw new \InvalidArgumentException('Invalid model passed');
        }

        return $value->getName();
    }
}
