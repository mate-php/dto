<?php

declare(strict_types=1);

namespace Tests\Unit;

use Mate\Dto\Dto;
use Mate\Dto\Attributes\Collection;
use Mate\Dto\Attributes\MapInputName;

class ItemDto extends Dto
{
    public string $name;
}

class UserProfileDto extends Dto
{
    #[MapInputName('first_name')]
    public string $firstName;

    #[Collection(ItemDto::class)]
    public array $items;
}

test('fromObject instantiates correctly', function () {
    $obj = new \stdClass();
    $obj->name = 'Object Item';
    
    $dto = ItemDto::fromObject($obj);
    
    expect($dto->name)->toBe('Object Item');
});

test('fromJson instantiates correctly', function () {
    $json = '{"name": "Json Item"}';
    
    $dto = ItemDto::fromJson($json);
    
    expect($dto->name)->toBe('Json Item');
});

test('fromDto clones data', function () {
    $original = new ItemDto(['name' => 'Original']);
    
    $clone = ItemDto::fromDto($original);
    
    expect($clone->name)->toBe('Original');
    expect($clone)->not->toBe($original);
});

test('map input name attribute works', function () {
    $data = [
        'first_name' => 'John', // Mapped name
        'items' => []
    ];
    
    $dto = UserProfileDto::fromArray($data);
    
    expect($dto->firstName)->toBe('John');
});

test('typed collection attribute works', function () {
    $data = [
        'first_name' => 'Jane',
        'items' => [
            ['name' => 'Item 1'],
            ['name' => 'Item 2']
        ]
    ];
    
    $dto = UserProfileDto::fromArray($data);
    
    expect($dto->items)->toHaveCount(2);
    expect($dto->items[0])->toBeInstanceOf(ItemDto::class);
    expect($dto->items[0]->name)->toBe('Item 1');
    expect($dto->items[1])->toBeInstanceOf(ItemDto::class);
    expect($dto->items[1]->name)->toBe('Item 2');
});

test('typed collection skips invalid items', function () {
    $data = [
        'first_name' => 'Jane',
        'items' => 'not an array'
    ];
    
    $dto = UserProfileDto::fromArray($data);
    
    expect(isset($dto->items))->toBeFalse(); // Should have skipped assignment
});

test('typed collection keeps plain items if not arrays', function () {
    $data = [
        'first_name' => 'Jane',
        'items' => [
            'not an array item',
            ['name' => 'Valid Item']
        ]
    ];
    
    $dto = UserProfileDto::fromArray($data);
    
    expect($dto->items[0])->toBe('not an array item');
    expect($dto->items[1])->toBeInstanceOf(ItemDto::class);
});

test('property without default is skipped if missing', function () {
    $dto = ItemDto::fromArray([]);
    expect(isset($dto->name))->toBeFalse();
});

test('nested dto from dto instance', function () {
    $item = new ItemDto(['name' => 'Child']);
    $dto = new class extends Dto {
        public ItemDto $child;
    };
    
    $dto->fill(['child' => $item]);
    expect($dto->child->name)->toBe('Child');
    expect($dto->child)->not->toBe($item); // It should be a new instance from fromDto
});

test('property with default is used if missing', function () {
    $dto = new class extends Dto {
        public string $name = 'Default Name';
    };
    
    $dto->fill([]);
    expect($dto->name)->toBe('Default Name');
});
