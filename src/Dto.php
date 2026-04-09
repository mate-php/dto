<?php

declare(strict_types=1);

namespace Mate\Dto;

use Mate\Dto\Contracts\DTOInterface;
use Mate\Dto\Traits\Exportable;
use Mate\Dto\Traits\Instantiable;

/**
 * Class Dto
 * Base class for all Data Transfer Objects.
 *
 * In PHP 8.4+, it is recommended to use Asymmetric Visibility for properties:
 * @example
 * public private(set) string $name;
 */
abstract class Dto implements DTOInterface
{
    use Instantiable;
    use Exportable;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->populate($data);
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function populate(array $data): void
    {
        $this->fill($data);
    }

    // ArrayAccess implementation
    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, (string) $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        $name = (string) $offset;
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        throw new \InvalidArgumentException("Property {$name} does not exist on " . static::class);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $name = (string) $offset;
        try {
            $reflection = new \ReflectionProperty($this, $name);
            $reflection->setValue($this, $value);
        } catch (\ReflectionException $e) {
            throw new \InvalidArgumentException("Property {$name} does not exist on " . static::class, 0, $e);
        } catch (\TypeError $e) {
            throw new \Mate\Dto\Exceptions\InvalidDataException(
                sprintf('Invalid type for property %s in %s: %s', $name, static::class, $e->getMessage()),
                0,
                $e
            );
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new \BadMethodCallException("Unsetting DTO properties is not allowed.");
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
