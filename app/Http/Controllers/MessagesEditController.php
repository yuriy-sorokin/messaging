<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Message\API\UpdateMessageCommand\UpdateMessageCommand;
use App\Domain\Message\API\UpdateMessageCommand\UpdateMessageCommandResult;
use App\Domain\Message\Repository\MessageRepository;
use App\Domain\User\Model\User;
use App\Framework\Decoration\CommandBus\CommandBusInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;

class MessagesEditController extends Controller
{
    public function __construct(private readonly CommandBusInterface $commandBus, private readonly MessageRepository $messageRepository) {}

    public function edit(int $id)
    {
        if (false === $this->checkUserPermission($id)) {
            return Redirect::route('messages-list');
        }

        return view('messages_edit', ['messageObject' => $this->messageRepository->find($id)]);
    }

    public function update(int $id, Request $request)
    {
        if (false === $this->checkUserPermission($id)) {
            return Redirect::route('messages-list');
        }

        /** @var UpdateMessageCommandResult $result */
        $result = $this->commandBus->dispatch(
            new UpdateMessageCommand(
                $id,
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

    private function checkUserPermission(int $messageId): bool
    {
        $user = $this->getUser();
        $message = $this->messageRepository->find($messageId);

        return null !== $user && null !== $message && $user->getId() === $message->getUser()->getId();
    }
}
