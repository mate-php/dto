<?php

declare(strict_types=1);

namespace Mate\Dto;

use Mate\Dto\Contracts\DTOInterface;
use Mate\Dto\Support\MetadataRegistry;
use Mate\Dto\Traits\Exportable;
use Mate\Dto\Traits\Instantiable;

/**
 * Class AbstractDto
 * Base class for all Data Transfer Objects.
 */
abstract class Dto implements DTOInterface
{
    use Instantiable;
    use Exportable;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->populate($data);
        }
    }

    protected function populate(array $data): void
    {
        $properties = MetadataRegistry::getProperties(static::class);
        $tempDto = static::fromArray($data);

        foreach ($properties as $metadata) {
            if ($metadata->reflection->isInitialized($tempDto)) {
                $metadata->reflection->setValue($this, $metadata->reflection->getValue($tempDto));
            }
        }
    }

    public function __get(string $name): mixed
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        throw new \InvalidArgumentException("Property {$name} does not exist on " . static::class);
    }

    public function __set(string $name, mixed $value): void
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $value;
            return;
        }

        throw new \InvalidArgumentException("Property {$name} does not exist on " . static::class);
    }

    // ArrayAccess implementation
    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, (string) $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->__get((string) $offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->__set((string) $offset, $value);
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
