<?php

declare(strict_types=1);

namespace Mate\Dto;

use Mate\Dto\Values\MissingValue;
use ReflectionProperty;
use ReflectionType;

final class Property
{
    private ?string $name = null;
    private mixed $defaultValue = null;
    private bool $allowNulls = false;
    private bool $hasDefaultValue = false;
    private ?ReflectionType $type = null;

    public function __construct(
        private ReflectionProperty $reflectionProperty
    ) {
        $this->name = $this->checkGetName();
        $this->hasDefaultValue = $this->checkHasDefaultValue();
        $this->defaultValue = $this->checkDefaultValue();
        $this->allowNulls = $this->checkAllowsNull();
        $this->type = $this->checkType();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function getAllowNulls(): bool
    {
        return $this->allowNulls;
    }

    public function getHasDefaultValue(): bool
    {
        return $this->hasDefaultValue;
    }

    // @codeCoverageIgnoreStart
    public function getType(): ?ReflectionType
    {
        return $this->type;
    }
    // @codeCoverageIgnoreEnd

    private function checkGetName(): string
    {
        return $this->reflectionProperty->getName();
    }

    private function checkDefaultValue(): mixed
    {
        return $this->reflectionProperty->getDefaultValue();
    }

    private function checkHasDefaultValue(): bool
    {
        return $this->reflectionProperty->hasDefaultValue();
    }

    private function checkAllowsNull(): bool
    {
        $type = $this->reflectionProperty->getType();

        if (!$type) {
            // @codeCoverageIgnoreStart
            return true;
            // @codeCoverageIgnoreEnd
        }

        return $type->allowsNull();
    }

    public function checkType(): ?ReflectionType
    {
        return $this->reflectionProperty->getType();
    }

    public function getValueFromData(array $data): mixed
    {
        if (array_key_exists($this->name, $data)) {
            return $data[$this->name];
        }

        if ($this->getHasDefaultValue()) {
            return $this->getDefaultValue();
        }

        if ($this->getAllowNulls()) {
            return null;
        }

        return new MissingValue();
    }
}
