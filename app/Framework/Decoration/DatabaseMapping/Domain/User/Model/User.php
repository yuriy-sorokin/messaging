<?php
declare(strict_types=1);

namespace App\Framework\Decoration\DatabaseMapping\Domain\User\Model;

use App\Framework\Decoration\Database\Laravel\LaravelModelInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements LaravelModelInterface
{
    public readonly \App\Domain\User\Model\User $user;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'int',
        'email' => EmailCast::class,
        'password' => PasswordCast::class,
    ];
    protected $fillable = [
        'id',
        'email',
        'password',
    ];

    #[\Override] public function toModel(): object
    {
        if (false === isset($this->user)) {
            $this->user = new \App\Domain\User\Model\User($this->email, $this->password);
            $id = &$this->user->getId();
            $id = $this->id;
        }

        return $this->user;
    }

    #[\Override] public static function fromModel(object $domainModel): self
    {
        return static::fromDomainModel($domainModel);
    }

    private static function fromDomainModel(\App\Domain\User\Model\User $user): self
    {
        return parent::newModelInstance(
            [
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ]
        );
    }
}
