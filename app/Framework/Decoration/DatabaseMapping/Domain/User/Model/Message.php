<?php
declare(strict_types=1);

namespace App\Framework\Decoration\DatabaseMapping\Domain\User\Model;

use App\Framework\Decoration\Database\Laravel\LaravelModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model implements LaravelModelInterface
{
    public readonly \App\Domain\Message\Model\Message $message;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'int',
        'message_text' => MessageTextCast::class,
        'category' => MessageCategoryCast::class,
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'id',
        'user',
        'message_text',
        'category',
        'created_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[\Override] public function toModel(): object
    {
        if (false === isset($this->message)) {
            /** @var User $user */
            $user = $this->user()->getResults();

            $this->message = new \App\Domain\Message\Model\Message(
                $user->toModel(),
                $this->message_text,
                $this->category,
                \DateTimeImmutable::createFromMutable($this->created_at)
            );
            $id = &$this->message->getId();
            $id = $this->id;
        }

        return $this->message;
    }

    #[\Override] public static function fromModel(object $domainModel): self
    {
        return static::fromDomainModel($domainModel);
    }

    private static function fromDomainModel(\App\Domain\Message\Model\Message $message): self
    {
        /** @var self $model */
        $model = parent::newModelInstance(
            [
                'id' => $message->getId(),
                'message_text' => $message->getMessageText(),
                'category' => $message->getMessageCategory(),
                'created_at' => $message->getCreatedAt(),
            ]
        );
        $model->user_id = $message->getUser()->getId();

        return $model;
    }
}
