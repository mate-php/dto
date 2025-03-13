<?php

declare(strict_types=1);

namespace Mate\Dto\Concern;

use Mate\Dto\Attributes\Flexible;
use ReflectionClass;

trait IsFlexible
{
    protected function isFlexible(): bool
    {
        return ! empty(
            (new ReflectionClass(static::class))->getAttributes(Flexible::class)
        );
    }
}
