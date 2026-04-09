<?php

declare(strict_types=1);

namespace Tests\Unit;

use Mate\Dto\Dto;

class PromotedDto extends Dto
{
    public function __construct(
        public string $name,
        public int $age = 18,
        public private(set) string $email = 'default@example.com'
    ) {
        parent::__construct();
    }
}

test('constructor property promotion works with instantiation', function () {
    $data = [
        'name' => 'John Promoted',
        'age' => 25,
        'email' => 'john@example.com',
    ];

    // Test via fromArray (which calls fill)
    $dto = PromotedDto::fromArray($data);

    expect($dto->name)->toBe('John Promoted');
    expect($dto->age)->toBe(25);
    expect($dto->email)->toBe('john@example.com');
});

test('promoted properties use default values if missing', function () {
    $data = [
        'name' => 'Jane Default',
    ];

    $dto = PromotedDto::fromArray($data);

    expect($dto->name)->toBe('Jane Default');
    expect($dto->age)->toBe(18); // Default from constructor
    expect($dto->email)->toBe('default@example.com'); // Default from constructor with private(set)
});

test('manual instantiation with promotion works', function () {
    // This is native PHP, but we verify it doesn't break our Dto logic
    $dto = new PromotedDto(name: 'Manual', age: 40);

    expect($dto->name)->toBe('Manual');
    expect($dto->age)->toBe(40);
    expect($dto->email)->toBe('default@example.com');
});
