<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Message\API\CreateMessageCommand\CreateMessageCommand;
use App\Domain\Message\API\CreateMessageCommand\CreateMessageCommandResult;
use App\Domain\User\Model\User;
use App\Framework\Decoration\CommandBus\CommandBusInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;

class MessagesCreateController extends Controller
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function create(Request $request)
    {
        $user = $this->getUser();

        if (null === $user) {
            return Redirect::route('login');
        }

        /** @var CreateMessageCommandResult $result */
        $result = $this->commandBus->dispatch(
            new CreateMessageCommand(
                $user->getEmail()->getEmail(),
                (string) $request->get('messageText'),
                (string) $request->get('messageCategory')
            )
        );

        if (null === $result->getMessage()) {
            return Redirect::back()->withErrors('Validation error');
        }

        return Redirect::route('messages-list');
    }

    private function getUser(): ?User
    {
        /** @var \App\Framework\Decoration\DatabaseMapping\Domain\User\Model\User $user */
        $user = Auth::user();

        return null === $user ? $user : $user->toModel();
    }
}
