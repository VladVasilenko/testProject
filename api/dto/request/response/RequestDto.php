<?php

declare(strict_types=1);

namespace api\dto\request\response;

use api\abstracts\AbstractDto;

class RequestDto extends AbstractDto
{
    private bool $result;
    private int $id;

    /**
     * @param  bool  $result
     * @param  int  $id
     */
    public function __construct(bool $result, int $id)
    {
        $this->result = $result;
        $this->id = $id;
    }

    public function toArray(): array
    {
        return [
            'result' => $this->result,
            'id' => $this->id,
        ];
    }
}