<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Message\API\DeleteMessageCommand\DeleteMessageCommand;
use App\Domain\User\Model\User;
use App\Framework\Decoration\CommandBus\CommandBusInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;

class MessagesDeleteController extends Controller
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function delete(int $messageId)
    {
        $user = $this->getUser();

        if (null === $user) {
            return Redirect::route('login');
        }

        $this->commandBus->dispatch(
            new DeleteMessageCommand($messageId, $user->getId())
        );

        return Redirect::route('messages-list');
    }

    private function getUser(): ?User
    {
        /** @var \App\Framework\Decoration\DatabaseMapping\Domain\User\Model\User $user */
        $user = Auth::user();

        return null === $user ? $user : $user->toModel();
    }
}
