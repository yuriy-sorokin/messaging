<?php
declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\Email\Model\Email;
use App\Domain\User\Model\User;
use App\Framework\Decoration\Database\DatabaseInterface;

class UserRepository
{
    public function __construct(private readonly DatabaseInterface $database) {}
    public function save(User $user): void
    {
        $this->database->save($user);
    }

    public function findByEmail(Email $email): ?User
    {
        return $this->database->findOne(User::class, ['email' => $email->getEmail()]);
    }
}
