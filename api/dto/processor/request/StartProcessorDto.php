<?php

declare(strict_types=1);

namespace api\dto\processor\request;

class StartProcessorDto
{
    private int $delay;

    /**
     * @param  int  $delay
     */
    public function __construct(int $delay)
    {
        $this->delay = $delay;
    }

    public function getDelay(): int
    {
        return $this->delay;
    }

}