<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\User\API\RegisterUserCommand\RegisterUserCommand;
use App\Domain\User\API\RegisterUserCommand\RegisterUserCommandResult;
use App\Framework\Decoration\CommandBus\CommandBusInterface;
use App\Http\ErrorTransformer\ErrorTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;

class RegisterUserController extends Controller
{
    public function __construct(private readonly CommandBusInterface $commandBus, private readonly ErrorTransformer $errorTransformer) {}

    public function register(Request $request)
    {
        /** @var RegisterUserCommandResult $result */
        $result = $this->commandBus->dispatch(
            new RegisterUserCommand((string) $request->get('email'), (string) $request->get('password'))
        );

        if (null !== $result->getError()) {
            return Redirect::back()->withErrors(
                $this->errorTransformer->transform($result->getError())
            );
        }

        return Redirect::back()->with('status', 'Registered');
    }
}
