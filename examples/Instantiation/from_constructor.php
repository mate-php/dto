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

$data = [
    "firstName" => "John",
    "lastName" => "Doe",
    "email" => "john.doe@example.com"
];
$dto = new UserDto($data);
print_r($dto->toArray());


$data = [
    "first_name" => "John",
    "last_name" => "Doe",
];
$dto = new UserDto($data);
print_r($dto->toArray());