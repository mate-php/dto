<?php

declare(strict_types=1);

namespace Mate\Dto\Concern;

use Mate\Dto\Attributes\Ignored;
use Mate\Dto\Exceptions\NotFlexibleException;
use Mate\Dto\Property;
use Mate\Dto\Values\MissingValue;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

trait Fill
{
    protected function fill(array $data): void
    {
        $properties = $this->collectProperties($data);

        $this->loadConcreteAttributes($properties, $data);
        $this->loadFlexibleAttributes($properties, $data);
    }

    protected function loadFlexibleAttributes(array $properties, array $data): void
    {
        $diff = array_diff_key($data, $properties);

        if (false === $this->isFlexible() && count($diff) > 0) {
            throw new NotFlexibleException(array_keys($diff));
        }

        foreach ($diff as $key => $value) {
            $this->dynamic[$key] = $value;
        }
    }

    protected function loadConcreteAttributes(array $properties, array &$data): void
    {
        /**
         * @var Property $property
         */
        foreach ($properties as $property) {
            $value = $property->getValueFromData($data);

            if ($value instanceof MissingValue) {
                continue;
            }

            $this->{$property->getName()} = $value;
        }
    }

    protected function collectProperties(array &$data): array
    {
        $properties = [];

        try {
            $reflectionClass = new ReflectionClass(static::class);
        } catch (ReflectionException) {
            return $properties;
        }

        foreach ($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->isStatic()) {
                continue;
            }

            if (!empty($property->getAttributes(Ignored::class))) {
                unset($data[$property->getName()]);
                continue;
            }

            $properties[$property->getName()] = new Property($property);
        }

        return $properties;
    }
}
