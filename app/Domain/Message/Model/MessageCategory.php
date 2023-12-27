<?php
declare(strict_types=1);

namespace App\Domain\Message\Model;

class MessageCategory
{
    public function __construct(private string $name) {}

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
