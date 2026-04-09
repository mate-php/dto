<?php

declare(strict_types=1);

namespace Mate\Dto\Support;

use Mate\Dto\Support\Helper;
use ReflectionClass;
use Mate\Dto\Attributes\MapInputName;
use Mate\Dto\Attributes\Collection;

/**
 * Class MetadataRegistry
 * Internal registry to cache DTO reflection metadata for high performance.
 * @internal
 */
final class MetadataRegistry
{
    /** @var array<string, array<string, PropertyMetadata>> */
    private static array $cache = [];

    /**
     * Get property metadata for a given class.
     *
     * @param string $class
     * @return array<string, PropertyMetadata>
     */
    public static function getProperties(string $class): array
    {
        if (isset(self::$cache[$class])) {
            return self::$cache[$class];
        }

        $reflection = new ReflectionClass($class);
        $properties = [];

        $constructor = $reflection->getConstructor();
        $constructorDefaults = [];
        if ($constructor) {
            foreach ($constructor->getParameters() as $param) {
                if ($param->isDefaultValueAvailable()) {
                    $constructorDefaults[$param->getName()] = $param->getDefaultValue();
                }
            }
        }

        foreach ($reflection->getProperties() as $property) {
            $name = $property->getName();
            $mapAttribute = $property->getAttributes(MapInputName::class)[0] ?? null;
            $collectionAttribute = $property->getAttributes(Collection::class)[0] ?? null;

            $inputName = $mapAttribute?->newInstance()->name ?? Helper::toSnakeCase($name);
            $databaseName = Helper::toSnakeCase($name);
            $defaultVal = $property->hasDefaultValue() ? $property->getDefaultValue() : ($constructorDefaults[$name] ?? null);
            $hasDefault = $property->hasDefaultValue() || array_key_exists($name, $constructorDefaults);

            $type = $property->getType();
            $className = null;
            $isBuiltin = true;

            if ($type instanceof \ReflectionNamedType) {
                $isBuiltin = $type->isBuiltin();
                $className = !$isBuiltin ? $type->getName() : null;
            }

            $properties[$name] = new PropertyMetadata(
                name: $name,
                inputName: $inputName,
                databaseName: $databaseName,
                isBuiltin: $isBuiltin,
                className: $className,
                isCollection: $collectionAttribute !== null,
                collectionType: $collectionAttribute?->newInstance()->type,
                isPublic: $property->isPublic(),
                reflection: $property,
                hasDefault: $hasDefault,
                defaultValue: $defaultVal
            );
        }

        return self::$cache[$class] = $properties;
    }

    /**
     * Clear the metadata cache (useful for tests or long-running processes if classes change).
     */
    public static function clear(): void
    {
        self::$cache = [];
    }
}
