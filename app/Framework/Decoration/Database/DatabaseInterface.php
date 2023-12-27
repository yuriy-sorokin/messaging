<?php
declare(strict_types=1);

namespace App\Framework\Decoration\Database;

interface DatabaseInterface
{
    public function save(object $model): void;
    public function delete(object $model): void;
    public function findOne(string $modelClass, array $criteria): ?object;
    public function findBy(string $modelClass, callable $criteria): array;
}
