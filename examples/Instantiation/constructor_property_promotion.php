<?php

declare(strict_types=1);

use Mate\Dto\Dto;

require __DIR__ . '/../../vendor/autoload.php';

class UserDto extends Dto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
    ) {
    }
}

$dto = new UserDto(
    firstName: "John",
    lastName: "Doe",
    email: "john.doe@example.com"
);

print_r($dto->toArray());