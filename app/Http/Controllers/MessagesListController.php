<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Message\API\MessageQuery\MessageQuery;
use App\Domain\Message\API\MessageQuery\MessageQueryResult;
use App\Framework\Decoration\CommandBus\CommandBusInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;

class MessagesListController extends Controller
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function list(Request $request)
    {
        if (null === Auth::user()) {
            return Redirect::route('login');
        }

        /** @var MessageQueryResult $result */
        $result = $this->commandBus->dispatch(
            new MessageQuery(
                (string) $request->get('categories'),
                (string) $request->get('emails'),
                (string) $request->get('fromDate'),
                (string) $request->get('toDate')
            )
        );

        return view('messages_list', ['messages' => $result->getMessages()]);
    }
}
