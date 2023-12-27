<?php
declare(strict_types=1);

namespace App\Domain\Message\Specification;

class IsMessageTextValidSpecification
{
    public function isSatisfiedBy(string $text): bool
    {
        $length = \strlen($text);

        return 0 < $length && 240 > $length;
    }
}
