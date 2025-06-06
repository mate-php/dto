<?php

declare(strict_types=1);

namespace Mate\Dto;

use ArrayAccess;
use Error;
use JsonSerializable;
use Mate\Dto\Concern\From;
use Mate\Dto\Concern\Exports;
use Mate\Dto\Concern\ArrayAccessMethods;
use Mate\Dto\Concern\Fill;
use Mate\Dto\Concern\IsFlexible;
use Mate\Dto\Exceptions\UndefinedPropertyException;
use Stringable;

abstract class Dto implements DtoContract, ArrayAccess, Stringable, JsonSerializable
{
    use From;
    use Exports;
    use Fill;
    use ArrayAccessMethods;
    use IsFlexible;

    protected array $dynamic = [];
    protected array $validProperties = [];
    protected bool $nestedToArrayEnabled = true;

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

    public function keys(): array
    {
        return array_keys($this->toArray());
    }

    public function values(): array
    {
        return array_values($this->toArray());
    }
}
