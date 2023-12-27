<?php
declare(strict_types=1);

namespace App\Http\ErrorTransformer;

interface ErrorTransformerInterface
{
    public function transform(object $error): ?string;

    public function getSupportedErrorClass(): string;
}
