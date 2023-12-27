<?php
declare(strict_types=1);

namespace App\Framework\Decoration\DatabaseMapping\Domain\User\Model;

use App\Domain\Message\Model\MessageText;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MessageTextCast implements CastsAttributes
{
    #[\Override] public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return new MessageText($value);
    }

    #[\Override] public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if (false === $value instanceof MessageText) {
            throw new \InvalidArgumentException('Invalid model passed');
        }

        return $value->getText();
    }
}
