<?php
declare(strict_types=1);

namespace App\Framework\Decoration\CommandBus;

interface CommandBusInterface
{
    public function dispatch(object $command): object;
}
