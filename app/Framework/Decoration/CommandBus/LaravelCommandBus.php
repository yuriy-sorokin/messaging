<?php
declare(strict_types=1);

namespace App\Framework\Decoration\CommandBus;

use Illuminate\Contracts\Events\Dispatcher;

class LaravelCommandBus implements CommandBusInterface
{
    public function __construct(private readonly Dispatcher $dispatcher) {}

    #[\Override] public function dispatch(object $command): object
    {
        return $this->dispatcher->dispatch($command)[0];
    }
}
