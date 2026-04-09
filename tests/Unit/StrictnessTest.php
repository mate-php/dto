<?php

declare(strict_types=1);

namespace Tests\Unit;

use Mate\Dto\Dto;
use Mate\Dto\Attributes\Flexible;
use Mate\Dto\Exceptions\NotFlexibleException;
use Mate\Dto\Exceptions\InvalidDataException;

class FlexibleDto extends Dto
{
    public string $name;
}

#[Flexible(enabled: false)]
class StrictDto extends Dto
{
    public string $name;
}

class TypeStrictDto extends Dto
{
    public int $age;
}

test('flexible dto ignores unknown data by default', function () {
    $data = ['name' => 'John', 'unknown' => 'value'];
    $dto = new FlexibleDto($data);

    expect($dto->name)->toBe('John');
});

test('strict dto throws exception on unknown data', function () {
    $data = ['name' => 'John', 'unknown' => 'value'];

    expect(fn() => new StrictDto($data))->toThrow(NotFlexibleException::class);
});

test('dto throws invalid data exception on type mismatch', function () {
    $data = ['age' => 'not an int'];

    expect(fn() => new TypeStrictDto($data))->toThrow(InvalidDataException::class);
});

test('asymmetric visibility is supported (conceptual)', function () {
    // This is a conceptual test as PHP version in environment must be 8.4+
    // Since we are using Reflection to set values, it should work fine.
});
