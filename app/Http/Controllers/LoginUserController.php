<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\User\API\LoginUserCommand\LoginUserCommand;
use App\Domain\User\API\LoginUserCommand\LoginUserCommandResult;
use App\Framework\Decoration\CommandBus\CommandBusInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;

class LoginUserController extends Controller
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function login(Request $request)
    {
        /** @var LoginUserCommandResult $result */
        $result = $this->commandBus->dispatch(
            new LoginUserCommand((string) $request->get('email'), (string) $request->get('password'))
        );

        if (null === $result->getUser()) {
            return Redirect::back()->withErrors('Not authenticated');
        }

        Auth::loginUsingId($result->getUser()->getId());

        return Redirect::route('messages-list');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
