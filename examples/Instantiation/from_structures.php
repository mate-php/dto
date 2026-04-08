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
print_r($dto->toArray());

/**
 * 
 */
$data = [
    "first_name" => "John",
    "last_name" => "Doe",
    "email" => "john.doe@example.com"
];
$dto = UserDto::fromArray($data);
print_r($dto->toArray());

/**
 * 
 */
$data = new stdClass();
$data->firstName = "John";
$data->lastName = "Doe";

$dto = UserDto::fromObject($data);
print_r($dto->toArray());

/**
 * 
 */
$data = new stdClass();
$data->firstName = "John";
$data->lastName = "Doe";

$dto = UserDto::fromJson(json_encode($data));
print_r($dto->toArray());

/**
 * 
 */
$dto = UserDto::fromDto($dto);
print_r($dto->toArray());