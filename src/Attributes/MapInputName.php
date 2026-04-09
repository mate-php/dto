<?php

declare(strict_types=1);

namespace Mate\Dto\Attributes;

use Attribute;

/**
 * Attribute MapInputName
 * Mapps an input field name to a DTO property.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class MapInputName
{
    public function __construct(
        public string $name
    ) {}
}
