<?php

namespace App\Providers;

use App\Framework\Decoration\CommandBus\CommandBusInterface;
use App\Framework\Decoration\CommandBus\LaravelCommandBus;
use App\Framework\Decoration\Database\DatabaseInterface;
use App\Framework\Decoration\Database\Laravel\LaravelDatabase;
use App\Framework\Decoration\Security\HashInterface;
use App\Framework\Decoration\Security\LaravelHash;
use App\Http\ErrorTransformer\ErrorTransformer;
use App\Http\ErrorTransformer\ErrorTransformerInterface;
use App\Http\ErrorTransformer\Transformer\RegisterUserCommandErrorTransformer;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CommandBusInterface::class, LaravelCommandBus::class);
        $this->app->bind(DatabaseInterface::class, LaravelDatabase::class);
        $this->app->bind(HashInterface::class, LaravelHash::class);

        $this->app->bind(RegisterUserCommandErrorTransformer::class);

        $this->app->tag([RegisterUserCommandErrorTransformer::class], ErrorTransformerInterface::class);

        $this->app->bind(ErrorTransformer::class, function (Application $app) {
            return new ErrorTransformer($app->get(LoggerInterface::class), ...$app->tagged(ErrorTransformerInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
