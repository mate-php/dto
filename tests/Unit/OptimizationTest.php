<?php

declare(strict_types=1);

namespace Tests\Unit;

use Mate\Dto\Dto;

class UserDto extends Dto
{
    public string $name;
    public int $age;
}

test('dto can be populated from array without redundant instantiation', function () {
    $data = ['name' => 'John Doe', 'age' => 30];
    $dto = new UserDto($data);

    expect($dto->name)->toBe('John Doe');
    expect($dto->age)->toBe(30);
});

test('dto can be instantiated from array factory', function () {
    $data = ['name' => 'Jane Doe', 'age' => 25];
    $dto = UserDto::fromArray($data);

    expect($dto->name)->toBe('Jane Doe');
    expect($dto->age)->toBe(25);
});

test('array access works after removing magic methods', function () {
    $dto = new UserDto(['name' => 'Tester']);
    
    expect($dto['name'])->toBe('Tester');
    
    $dto['age'] = 40;
    expect($dto->age)->toBe(40);
});
