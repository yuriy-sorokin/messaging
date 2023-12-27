<?php
declare(strict_types=1);

namespace App\Framework\Decoration\Database\Laravel;

use App\Domain\ModelWithIdInterface;
use App\Framework\Decoration\Database\DatabaseInterface;

class LaravelDatabase implements DatabaseInterface
{
    public function __construct(private readonly DomainToDatabaseModelMapping $modelMapping) {}

    #[\Override] public function save(object $model): void
    {
        $laravelModel = $this->modelMapping->get($model);

        if ($model instanceof ModelWithIdInterface && false === empty($model->getId())) {
            $laravelModel->exists = true;
        }

        $laravelModel->save();

        if ($model instanceof ModelWithIdInterface) {
            $id = &$model->getId();
            $id = $laravelModel->id;
        }
    }

    #[\Override] public function delete(object $model): void
    {
        $laravelModel = $this->modelMapping->get($model);
        $laravelModel->exists = true;

        $laravelModel->delete();
    }

    #[\Override] public function findOne(string $modelClass, array $criteria): ?object
    {
        $laravelModelClass = $this->modelMapping->getLaravelModelClass($modelClass);
        $laravelModel = null;

        foreach ($criteria as $key => $value) {
            $laravelModel = $laravelModelClass::where($key, $value);
        }

        return $this->convertToDomainModel($laravelModel->first());
    }

    #[\Override] public function findBy(string $modelClass, callable $criteria): array
    {
        $laravelModelClass = $this->modelMapping->getLaravelModelClass($modelClass);
        $laravelModel = $laravelModelClass::newModelInstance();

        $laravelModel = $criteria($laravelModel);

        $models = [];

        foreach ($laravelModel->get() as $item) {
            $models[] = $this->convertToDomainModel($item);
        }

        return $models;
    }

    private function convertToDomainModel(?LaravelModelInterface $laravelModel): ?object
    {
        return null === $laravelModel ? $laravelModel : $laravelModel->toModel();
    }
}
