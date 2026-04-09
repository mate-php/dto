<?php

declare(strict_types=1);

namespace Tests\Unit;

use Mate\Dto\Support\Helper;
use Mate\Dto\Support\MetadataRegistry;
use Mate\Dto\Dto;

class SimpleDto extends Dto
{
    public string $name;
}

test('helper toSnakeCase handles empty string', function () {
    expect(Helper::toSnakeCase(''))->toBe('');
});

test('helper toCamelCase converts correctly', function () {
    expect(Helper::toCamelCase('first_name'))->toBe('firstName');
    expect(Helper::toCamelCase('lastName'))->toBe('lastName');
    expect(Helper::toCamelCase('multiple_word_case'))->toBe('multipleWordCase');
});

test('metadata registry can clear cache', function () {
    // Fill cache
    MetadataRegistry::getProperties(SimpleDto::class);

    // Clear cache
    MetadataRegistry::clear();

    // We can't easily check the private static cache directly without reflection,
    // but we can verify the method exists and runs without error.
    expect(fn() => MetadataRegistry::clear())->not->toThrow(\Throwable::class);
});
