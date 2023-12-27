<?php
declare(strict_types=1);

namespace App\Domain\Message\API\MessageQuery;

class MessageQuery
{
    public function __construct(
        private readonly string $categories,
        private readonly string $userEmails,
        private readonly string $fromDate,
        private readonly string $toDate
    ) {}

    public function getCategories(): string
    {
        return $this->categories;
    }

    public function getUserEmails(): string
    {
        return $this->userEmails;
    }

    public function getFromDate(): string
    {
        return $this->fromDate;
    }

    public function getToDate(): string
    {
        return $this->toDate;
    }
}
