<?php

declare(strict_types=1);

namespace api\dto\processor\response;

use api\abstracts\AbstractDto;

class ProcessorSuccessDto extends AbstractDto
{
    private bool $result = true;

    public function toArray(): array
    {
        return [
            'result' => $this->result,
        ];
    }
}