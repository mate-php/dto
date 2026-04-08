<?php

declare(strict_types=1);

namespace Mate\Dto\Attributes;

use Attribute;

/**
 * Attribute Flexible
 * Controls whether a DTO should allow unknown data or throw an exception.
 */
#[Attribute(Attribute::TARGET_CLASS)]
readonly class Flexible
{
    public function __construct(
        public bool $enabled = true
    ) {
    }
}
