<?php

declare(strict_types=1);

namespace Mate\Dto\Attributes;

use Attribute;

/**
 * Attribute Collection
 * Specifies the class name for items within a typed collection (array).
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class Collection
{
    public function __construct(
        public string $type
    ) {}
}
