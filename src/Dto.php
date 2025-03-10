<?php

declare(strict_types=1);

namespace Mate\Dto;

use ArrayAccess;
use Error;
use JsonSerializable;
use Mate\Dto\Concern\From;
use Mate\Dto\Concern\To;
use Mate\Dto\Attributes\Flexible;
use Mate\Dto\Concern\Fill;
use Mate\Dto\Exceptions\UndefinedPropertyException;
use ReflectionClass;
use Stringable;

abstract class Dto implements DtoContract, ArrayAccess, Stringable, JsonSerializable
{
    use From;
    use To;
    use Fill;

    protected array $dynamic = [];
    protected array $validProperties = [];

    public function __construct(mixed ...$data)
    {
        $this->fill($data);
    }

    public function __isset(mixed $property): bool
    {
        return array_key_exists($property, $this->validProperties);
    }

    public function __get(string $property): mixed
    {
        if (!$this->__isset($property)) {
            throw new UndefinedPropertyException($property);
        }

        return array_key_exists($property, $this->dynamic)
            ? $this->dynamic[$property]
            : $this->$property;
    }

    public function __set(string $property, mixed $value): void
    {
        throw new Error('Dto are immutable. Create a new DTO to set a new value.');
    }

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
        throw new Error('Dto are immutable. Create a new DTO to set a new value.');
    }

    protected function getPublicValues(): array
    {
        $values = get_object_vars($this) + $this->dynamic;
        return array_intersect_key($values, $this->validProperties);
    }

    protected function isFlexible(): bool
    {
        return ! empty(
            (new ReflectionClass(static::class))->getAttributes(Flexible::class)
        );
    }
}
