<?php
declare(strict_types=1);

namespace App\Domain\Message\API\MessageQuery;

use App\Domain\Message\Repository\MessageRepository;
use Illuminate\Database\Eloquent\Model;

class MessageQueryHandler
{
    public function __construct(private readonly MessageRepository $messageRepository) {}

    public function handle(MessageQuery $messageQuery): MessageQueryResult
    {
        $query = static function (Model $model) use ($messageQuery) {
            if (false === empty($messageQuery->getCategories())) {
                $model = $model->whereIn('category', \explode(' ', $messageQuery->getCategories()));
            }

            if (false === empty($messageQuery->getUserEmails())) {
                $model = $model::whereHas('user', function ($query) use ($messageQuery) {
                    $query->whereIn('email', \explode(' ', $messageQuery->getUserEmails()));
                });
            }

            if (false === empty($messageQuery->getFromDate())) {
                $model = $model->where('created_at', '>=', $messageQuery->getFromDate());
            }

            if (false === empty($messageQuery->getToDate())) {
                $model = $model->where('created_at', '<=', $messageQuery->getToDate());
            }

            return $model;
        };

        return new MessageQueryResult(...$this->messageRepository->findBy($query));
    }
}
