<?php

declare(strict_types=1);

namespace Mate\Dto;

use Mate\Dto\Contracts\DTOInterface;
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
        if (property_exists($this, $name)) {
            $this->{$name} = $value;
            return;
        }

        throw new \InvalidArgumentException("Property {$name} does not exist on " . static::class);
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
