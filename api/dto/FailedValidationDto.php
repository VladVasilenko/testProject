<?php

declare(strict_types=1);

namespace api\dto;

use api\abstracts\AbstractDto;

class FailedValidationDto extends AbstractDto
{
    private bool $result = false;

    public function toArray(): array
    {
        return [
            'result' => $this->result,
        ];
    }
}