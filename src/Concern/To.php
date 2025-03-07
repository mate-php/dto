<?php

declare(strict_types=1);

namespace Mate\Dto\Concern;

use Mate\Dto\Dto;

trait To
{
    public function toArray(): array
    {
        $data = $this->getPublicValues();
        return $this->nestedToArray($data);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    protected function nestedToArray(array $data): array
    {
        $fn = static function ($value) {
            if ($value instanceof Dto) {
                return $value->toArray();
            }
            return $value;
        };

        return array_map(
            $fn,
            $data
        );
    }
}
