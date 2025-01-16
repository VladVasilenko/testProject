<?php

declare(strict_types=1);

namespace api\abstracts;
abstract class AbstractDto
{
    abstract public function toArray(): array;
}