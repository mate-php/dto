<?php

declare(strict_types=1);

namespace Mate\Dto\Traits;

use Mate\Dto\Contracts\DTOInterface;
use Mate\Dto\Support\MetadataRegistry;
use ReflectionProperty;

/**
 * Trait Exportable
 * Provides methods for DTO serialization/export.
 */
trait Exportable
{
    protected function getValueForArray(ReflectionProperty $property): mixed
    {
        $value = $property->getValue($this);

        if ($value instanceof DTOInterface) {
            return $value->toArray();
        } elseif (is_array($value)) {
            return array_map(fn($item) => $item instanceof DTOInterface ? $item->toArray() : $item, $value);
        }

        return $value;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];
        $properties = MetadataRegistry::getProperties(static::class);

        foreach ($properties as $metadata) {
            if ($metadata->isPublic || $metadata->reflection->isPublic()) {
                $result[$metadata->name] = $this->getValueForArray($metadata->reflection);
            }
        }

        return $result;
    }

    /**
     * @return array<string, mixed>
     */
    public function toDatabase(): array
    {
        $result = [];
        $properties = MetadataRegistry::getProperties(static::class);

        foreach ($properties as $metadata) {
            if ($metadata->isPublic || $metadata->reflection->isPublic()) {
                $result[$metadata->databaseName] = $this->getValueForArray($metadata->reflection);
            }
        }

        return $result;
    }

    public function toJson(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
