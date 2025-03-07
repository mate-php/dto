<?php

declare(strict_types=1);

namespace Mate\Dto\Exceptions;

use Exception;
use Throwable;

class DtoException extends Exception
{
    protected array|string $toReplace = [];
    protected string $default = '';

    public function __construct(string|array $message, ?Throwable $previous = null)
    {
        parent::__construct(
            $this->renderMessage($message),
            0,
            $previous
        );
    }

    protected function renderMessage(array|string $replaces): string
    {
        return str_replace($this->toReplace, $replaces, $this->default);
    }
}
