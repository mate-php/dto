<?php

declare(strict_types=1);

namespace Mate\Dto;

interface DtoContract
{
    public static function fromArray(array $values);

    public static function fromObject(object $values);

    public static function fromJson(string $values);

    public function toArray(): array;

    public function jsonSerialize(): mixed;

    public function toJson(): string;
}
