<?php

declare(strict_types=1);

namespace Tests\Unit;

use Mate\Dto\Dto;

class ModernDto extends Dto
{
    public private(set) string $name;
    public private(set) int $age;
}

test('asymmetric visibility allows reading but prevents writing from outside', function () {
    $dto = new ModernDto(['name' => 'John', 'age' => 30]);
    
    // Read access is allowed
    expect($dto->name)->toBe('John');
    expect($dto->age)->toBe(30);
    
    // Write access from outside should throw an Error in PHP 8.4
    expect(fn() => $dto->name = 'Jane')->toThrow(\Error::class, 'Cannot modify private(set) property');
});

test('reflection-based filling bypasses private set', function () {
    $dto = new ModernDto(['name' => 'Original']);
    
    expect($dto->name)->toBe('Original');
    
    // fill() uses reflection, so it should be allowed to update private(set) properties
    $dto->fill(['name' => 'Updated']);
    
    expect($dto->name)->toBe('Updated');
});

test('asymmetric visibility with array access', function () {
    $dto = new ModernDto(['name' => 'John']);
    
    expect($dto['name'])->toBe('John');
    
    // offsetSet uses simple variable property access: $this->{$name} = $value;
    // Since offsetSet is defined IN the Dto class, it should have access to set its own private(set) properties.
    $dto['name'] = 'ArraySet';
    
    expect($dto->name)->toBe('ArraySet');
});

test('offsetSet throws invalid data exception on type mismatch', function () {
    $dto = new ModernDto();
    expect(fn() => $dto['age'] = 'not an int')->toThrow(\Mate\Dto\Exceptions\InvalidDataException::class);
});
