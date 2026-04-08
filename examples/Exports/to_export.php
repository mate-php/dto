<?php

declare(strict_types=1);

use Mate\Dto\Dto;

require __DIR__ . '/../../vendor/autoload.php';

class UserDto extends Dto
{
    public string $firstName;
    public string $lastName;
    public ?string $email = null;
}

/**
 * 
 */
$data = [
    "firstName" => "John",
    "lastName" => "Doe",
    "email" => "john.doe@example.com"
];
$dto = UserDto::fromArray($data);

echo "toArray: " . print_r($dto->toArray(), true) . PHP_EOL;
echo "toDatabase: " . print_r($dto->toDatabase(), true) . PHP_EOL;
echo "toJson: " . print_r($dto->toJson(), true) . PHP_EOL;
echo "json_encode: " . print_r(json_encode($dto), true) . PHP_EOL;