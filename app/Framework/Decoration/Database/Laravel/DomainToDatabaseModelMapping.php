<?php
declare(strict_types=1);

namespace App\Framework\Decoration\Database\Laravel;

use App\Domain\Message\Model\Message;
use App\Domain\User\Model\User;
use Illuminate\Database\Eloquent\Model;

class DomainToDatabaseModelMapping
{
    private const MAPPING = [
        User::class => \App\Framework\Decoration\DatabaseMapping\Domain\User\Model\User::class,
        Message::class => \App\Framework\Decoration\DatabaseMapping\Domain\User\Model\Message::class,
    ];

    public function get(object $domainModel): Model
    {
        $laravelModelClass = $this->getLaravelModelClass($domainModel::class);
        
        if (true === \is_a($laravelModelClass, LaravelModelInterface::class, true)) {
            return $laravelModelClass::fromModel($domainModel);
        }
    }

    public function getLaravelModelClass(string $domainModelClass): string
    {
        return static::MAPPING[$domainModelClass];
    }
}
