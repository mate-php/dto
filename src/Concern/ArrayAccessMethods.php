<?php

declare(strict_types=1);

namespace Mate\Dto\Concern;

use Error;

trait ArrayAccessMethods
{
    public function offsetExists(mixed $property): bool
    {
        return $this->__isset($property);
    }

    public function offsetGet(mixed $property): mixed
    {
        return $this->__get($property);
    }

    public function offsetSet(mixed $property, mixed $value): void
    {
        $this->__set($property, $value);
    }

    public function offsetUnset(mixed $property): void
    {
        throw new Error('Dto are immutable. Create a new DTO to set a new value: ' . $property);
    }
}
