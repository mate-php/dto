<?php

declare(strict_types=1);

use Mate\Dto\Attributes\Flexible;
use Mate\Dto\Dto;

require __DIR__ . '/../../vendor/autoload.php';

#[Flexible(enabled: false)]
class UserDto extends Dto
{
    public string $firstName;
    public string $lastName;
    public ?string $email = null;
}

$data = [
    "firstName" => "John",
    "lastName" => "Doe",
    "email" => "john.doe@example.com",
    "key" => "value"
];
$dto = new UserDto($data);
print_r($dto->toArray()); // throw exception
