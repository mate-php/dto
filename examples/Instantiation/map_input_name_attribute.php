<?php

declare(strict_types=1);

use Mate\Dto\Attributes\Collection;
use Mate\Dto\Attributes\MapInputName;
use Mate\Dto\Dto;

require __DIR__ . '/../../vendor/autoload.php';

class RoleDto extends Dto
{
    public string $name;
}


class UserDto extends Dto
{
    public string $firstName;
    public string $lastName;
    public ?string $email = null;

    #[MapInputName("permissions")]
    #[Collection(RoleDto::class)]
    public array $roles = [];
}

$data = [
    "firstName" => "John",
    "lastName" => "Doe",
    "email" => "john.doe@example.com",
    "permissions" => [
        ['name' => 'Admin'],
        ['name' => 'Editor']
    ]
];
$dto = new UserDto($data);
print_r($dto);
