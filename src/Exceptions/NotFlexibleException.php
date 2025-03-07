<?php

declare(strict_types=1);

namespace Mate\Dto\Exceptions;

class NotFlexibleException extends DtoException
{
    protected array|string $toReplace = '[values]';
    protected string $default = 'Some provided values are not declared as properties: [values]';

    protected function renderMessage(array|string $replaces): string
    {
        $replaces = is_array($replaces) ? implode(", ", $replaces) : $replaces;
        return parent::renderMessage($replaces);
    }
}
