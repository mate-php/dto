<?php

declare(strict_types=1);

namespace Mate\Dto\Concern;

use Mate\Dto\Dto;

trait Exports
{
    public function toArray(): array
    {
        $data = $this->getPublicValues();
        return $this->nestedToArray($data);
    }

    public function toDatabase(): array
    {
        $toSnakeCase = fn (string $value) => strtolower(
            preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $value)
        );

        $values = [];
        foreach ($this->toArray() as $key => $value) {
            $values[$toSnakeCase($key)] = $value;
        }

        return $values;
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
        $callback = static function ($value) {
            if ($value instanceof Dto) {
                return $value->toArray();
            }
            return $value;
        };

        return array_map(
            $callback,
            $data
        );
    }

    protected function getPublicValues(): array
    {
        $values = get_object_vars($this) + $this->dynamic;
        return array_intersect_key($values, $this->validProperties);
    }
}
