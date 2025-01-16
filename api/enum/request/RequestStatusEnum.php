<?php

declare(strict_types=1);

namespace api\enum\request;

class RequestStatusEnum
{
    public const APPROVED = 'approved';
    public const DECLINED = 'declined';
    public const WAITING = 'waiting';
}