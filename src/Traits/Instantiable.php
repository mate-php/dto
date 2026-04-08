<?php

declare(strict_types=1);

namespace Mate\Dto\Traits;

use Mate\Dto\Contracts\DTOInterface;
use Mate\Dto\Support\MetadataRegistry;
use ReflectionClass;

/**
 * Trait Instantiable
 * Provides factory methods for DTO instantiation.
 */
trait Instantiable
{
    public static function fromArray(array $data): static
    {
        $reflection = new \ReflectionClass(static::class);
        $dto = $reflection->newInstanceWithoutConstructor();

        $dto->fill($data);

        return $dto;
    }

    protected function fill(array $data): void
    {
        $properties = MetadataRegistry::getProperties(static::class);

        foreach ($properties as $metadata) {
            $value = $data[$metadata->inputName] ?? $data[$metadata->name] ?? null;

            if ($value === null && !\array_key_exists($metadata->inputName, $data) && !\array_key_exists($metadata->name, $data)) {
                if ($metadata->hasDefault) {
                    $value = $metadata->defaultValue;
                } else {
                    continue;
                }
            }

            // Handle nested DTOs
            if ($metadata->className !== null && is_subclass_of($metadata->className, DTOInterface::class)) {
                if (\is_array($value)) {
                    $value = $metadata->className::fromArray($value);
                } elseif ($value instanceof DTOInterface) {
                    $value = $metadata->className::fromDto($value);
                }
            }

            // Handle typed collections
            elseif ($metadata->isCollection && $metadata->collectionType !== null) {
                if (\is_array($value)) {
                    if (is_subclass_of($metadata->collectionType, DTOInterface::class)) {
                        $collectionType = $metadata->collectionType;
                        $value = array_map(
                            static fn($item) => \is_array($item) ? $collectionType::fromArray($item) : $item,
                            $value
                        );
                    }
                } else {
                    // Skip assignment if collection expected an array but got something else
                    continue;
                }
            }

            try {
                $metadata->reflection->setValue($this, $value);
            } catch (\TypeError $e) {
                // If it's a type error and we want to be graceful, we could skip or throw a specific exception.
                if (!$metadata->reflection->isInitialized($this)) {
                    continue;
                }
                throw $e;
            }
        }
    }

    public static function fromObject(object $data): static
    {
        return static::fromArray((array) $data);
    }

    public static function fromJson(string $json): static
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return static::fromArray($data);
    }

    public static function fromDto(DTOInterface $dto): static
    {
        return static::fromArray($dto->toArray());
    }
}
