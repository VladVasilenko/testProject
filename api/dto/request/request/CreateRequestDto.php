<?php

declare(strict_types=1);

namespace api\dto\request\request;


class CreateRequestDto
{
    private int $userId;
    private int $amount;
    private int $term;

    /**
     * @param  int  $userId
     * @param  int  $amount
     * @param  int  $term
     */
    public function __construct(int $userId, int $amount, int $term)
    {
        $this->userId = $userId;
        $this->amount = $amount;
        $this->term = $term;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getTerm(): int
    {
        return $this->term;
    }
}