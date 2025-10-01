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
        $nestedToArrayEnabled = (
            !isset($this->nestedToArrayEnabled)
            || (isset($this->nestedToArrayEnabled) && $this->nestedToArrayEnabled === true)
        ) ? true : false;

        $callback = static function ($value) use ($nestedToArrayEnabled) {
            if ($value instanceof Dto) {
                return $nestedToArrayEnabled ? $value->toArray() : $value;
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

        foreach ($this->inValidProperties as $inValidProperty) {
            if (array_key_exists($inValidProperty, $values)) {
                unset($values[$inValidProperty]);
            }
        }

        return $values;
    }
}
