<?php

declare(strict_types=1);

namespace Mate\Dto\Concern;

use Mate\Dto\Dto;

trait From
{
    public static function fromArray(array $values): static
    {
        return new static(...$values);
    }

    public static function fromObject(object $values): static
    {
        return static::fromArray((array) $values);
    }

    public static function fromJson(string $values): static
    {
        return static::fromArray(json_decode($values, true));
    }

    public static function fromDto(Dto $dto): static
    {
        return static::fromArray($dto->toArray());
    }
}
