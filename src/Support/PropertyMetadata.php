<?php

declare(strict_types=1);

namespace Mate\Dto\Support;

use ReflectionProperty;

/**
 * Value object for property metadata.
 * @internal
 */
final readonly class PropertyMetadata
{
    public function __construct(
        public string $name,
        public string $inputName,
        public string $databaseName,
        public bool $isBuiltin,
        public ?string $className,
        public bool $isCollection,
        public ?string $collectionType,
        public bool $isPublic,
        public ReflectionProperty $reflection,
        public bool $hasDefault = false,
        public mixed $defaultValue = null
    ) {}
}
