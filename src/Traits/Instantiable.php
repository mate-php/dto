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
        $reflection = new \ReflectionClass(static::class);
        $flexibleAttribute = $reflection->getAttributes(\Mate\Dto\Attributes\Flexible::class)[0] ?? null;
        $isFlexible = $flexibleAttribute ? $flexibleAttribute->newInstance()->enabled : true;

        if (!$isFlexible) {
            $allowedKeys = array_map(
                static fn($metadata) => [$metadata->name, $metadata->inputName],
                $properties
            );
            $allowedKeys = array_merge(...array_values($allowedKeys));
            $unknownKeys = array_diff(array_keys($data), $allowedKeys);

            if (!empty($unknownKeys)) {
                throw new \Mate\Dto\Exceptions\NotFlexibleException(
                    sprintf('Unknown properties [%s] passed to non-flexible DTO %s', implode(', ', $unknownKeys), static::class)
                );
            }
        }

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
                    continue;
                }
            }

            try {
                $metadata->reflection->setValue($this, $value);
            } catch (\TypeError $e) {
                throw new \Mate\Dto\Exceptions\InvalidDataException(
                    sprintf('Invalid type for property %s in %s: %s', $metadata->name, static::class, $e->getMessage()),
                    0,
                    $e
                );
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
