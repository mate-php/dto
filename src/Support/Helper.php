<?php

declare(strict_types=1);

namespace Mate\Dto\Support;

/**
 * Utility class
 */
class Helper
{
    /**
     * Convert a string to snake_case.
     */
    public static function toSnakeCase(string $value): string
    {
        if (empty($value)) {
            return $value;
        }

        $value = preg_replace('/[\s-]+/', '_', $value);
        $value = preg_replace('/(?<!^)[A-Z]/', '_$0', $value);

        return strtolower(preg_replace('/_+/', '_', $value));
    }

    /**
     * Convert a string to camelCase.
     */
    public static function toCamelCase(string $value): string
    {
        $value = self::toSnakeCase($value);
        return lcfirst(str_replace('_', '', ucwords($value, '_')));
    }
}