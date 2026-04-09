<?php

declare(strict_types=1);

namespace Tests\Unit;

use Mate\Dto\Dto;

class AddressDto extends Dto
{
    public string $city;
    public string $streetName;
}

class ProfileDto extends Dto
{
    public string $firstName;
    public AddressDto $address;
}

test('toDatabase uses snake_case keys', function () {
    $dto = new AddressDto(['city' => 'NY', 'streetName' => '5th Ave']);

    $dbData = $dto->toDatabase();

    expect($dbData)->toBe([
        'city' => 'NY',
        'street_name' => '5th Ave',
    ]);
});

test('toJson returns correct json string', function () {
    $dto = new AddressDto(['city' => 'Paris', 'streetName' => 'Main St']);

    expect($dto->toJson())->toBe('{"city":"Paris","streetName":"Main St"}');
});

test('jsonSerialize returns array for json_encode', function () {
    $dto = new AddressDto(['city' => 'Berlin', 'streetName' => 'Wall St']);

    expect(json_encode($dto))->toBe('{"city":"Berlin","streetName":"Wall St"}');
});

test('nested dto export', function () {
    $data = [
        'firstName' => 'John',
        'address' => [
            'city' => 'London',
            'streetName' => 'Baker St',
        ],
    ];

    $profile = new ProfileDto($data);

    $array = $profile->toArray();

    expect($array['address'])->toBeArray();
    expect($array['address']['city'])->toBe('London');
    expect($array['address']['streetName'])->toBe('Baker St');
});

test('exporting collection of dtos', function () {
    // We'll test this properly in InstantiationTest along with the #[Collection] attribute,
    // but here we can test the basic array handle in getValueForArray
    $dto = new class extends Dto {
        public array $items;
    };

    $child = new AddressDto(['city' => 'Madrid', 'streetName' => 'Gran Via']);
    $dto->items = [$child, 'plain string'];

    $array = $dto->toArray();

    expect($array['items'][0])->toBeArray();
    expect($array['items'][0]['city'])->toBe('Madrid');
    expect($array['items'][1])->toBe('plain string');
});
