<?php

declare(strict_types=1);

namespace Mate\Dto\Exceptions;

class UndefinedPropertyException extends DtoException
{
    protected array|string $toReplace = '[property]';
    protected string $default = 'Undefined property: [property]';
}
