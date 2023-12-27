<?php
declare(strict_types=1);

namespace App\Framework\Decoration\Database\Laravel;

interface LaravelModelInterface
{
    public function toModel(): object;
    public static function fromModel(object $domainModel): self;
}
