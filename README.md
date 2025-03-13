<div align="center">
    <p>
        <h1>Mate - DTO</h1>
        Simple Data Transfer Objects (DTO) for any framework
    </p>
</div>

<p align="center">

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://packagist.org/packages/matephp/dto)
[![Latest Stable Version](https://img.shields.io/packagist/v/matephp/dto)](https://packagist.org/packages/matephp/dto)
[![Unstable Version](https://img.shields.io/badge/unstable-dev--main-orange)](https://packagist.org/packages/matephp/dto)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/matephp/dto.svg?logo=php)](https://packagist.org/packages/matephp/dto)
[![Total Downloads](https://img.shields.io/packagist/dt/matephp/dto)](https://packagist.org/packages/matephp/dto)
[![License](https://img.shields.io/packagist/l/matephp/dto)](https://packagist.org/packages/matephp/dto)
[![Hits-of-Code](https://hitsofcode.com/github/mate-php/dto?branch=main)](https://hitsofcode.com/github/mate-php/dto/json?branch=main)

</p>

A DTO, or Data Transfer Object, is a design pattern used to transfer data between different layers or subsystems of an application. Its main function is to encapsulate data and minimize the number of calls to the database or other services.

Key features of DTOs:

- Simplicity: DTOs are simple objects that only contain data and no business logic.
- Encapsulation: DTOs encapsulate data, allowing you to control how information is accessed and modified.
- Efficiency: DTOs can improve performance by reducing the amount of data transferred between layers.
- Decoupling: DTOs help decouple different layers of an application, making code maintenance and evolution easier.

Some use cases:

- When you need to transfer data between different layers of an application, such as the presentation layer and the data layer.
- When you need to expose data through an API.
- When you need to optimize the performance of your application by reducing the amount of data being transferred.

# Instalation

__Via Composer__

```sh
composer require mate/dto
```

# Documentation

## Define DTO properties

Properties can be set in the class definition or in the constructor ([Constructor Property Promotion](https://wiki.php.net/rfc/constructor_promotion))


```php
use Mate\Dto\Dto;

class MyDto extends Dto
{
    public string $property1;
    public string $property2;
}

// or

class MyDto extends Dto
{
    public function __constuct(
        public string $property1,
        public string $property2
    ) {
    }
}
```

## DTO instantation

You can create DATA in different ways:

__Using `constructor`__

```php
// ...

$dto = new MyDto(
    property1: 'value 1',
    property2: 'value 2',
);
```

__From array using `fromArray` static method__

```php
// ...

$data = [
    "property1" => 'value 1',
    "property2" => 'value 2',
];

$dto = MyDto::fromArray($data);
```

__From object using `fromObject` static method__

```php
// ...

$data = new stdClass();
$data->property1 = "value 1";
$data->property2 = "value 2";

$dto = MyDto::fromObject($data);
```

__From json string using `fromJson` static method__

```php
// ...

$obj = new stdClass();
$obj->property1 = "value 1";
$obj->property2 = "value 2";

$data = json_encode($obj);

$dto = MyDto::fromJson($data);
```

__from other DTO instance using `fromDto` static method__


```php
// ...

$otherDto = new MyDto(
    property1: 'value 1',
    property2: 'value 2',
);

$dto = MyDto::fromDto($otherDto);
```

## Creating DTOs with dynamic properties (Flexible DTO)

To create a DTO that allows defining properties dynamically, the [attribute](https://www.php.net/manual/en/language.attributes.php) `#[Flexible]` is used

```php
use Mate\Dto\Dto;
use Mate\Dto\Attributes\Flexible;

#[Flexible]
class MyFlexibleDTo extends Dto
{
    public function __constructor(
        public string $property1,
        public string $property2
    ) {
    }
}

$dto = new MyFlexibleDTo(
    property1: 'value 1',
    property2: 'value 2',
    property3: 'value 3'
);

echo $dto->property3; // print: value 3
```

When creating a DTO with dynamic properties but not setting the `#[Flexible]` attribute, an exception of type `Mate\Dto\Exceptions\NotFlexibleException` is thrown.

## Access DTO data

DTO data can be accessed as a property of an object or through array syntax

```php
// ...

$dto = new MyDto(
    property1: 'value 1',
    property2: 'value 2',
);

echo $dto->property1; // print: value 1
echo $dto->property2; // print: value 2

echo $dto['property1']; // print: value 1
echo $dto['property2']; // print: value 2
```

__Uninitialized properties__

When an attribute is called that was not initialized, an `\Error` exception is thrown.

```php
// ...

$dto = new MyDto(
    property1: 'value 1',
);

echo $dto->property2; // throw: \Error exception
```

__Properties with default value__

When a value is not sent to a property, the default value is used if it has one.

```php
use Mate\Dto\Dto;

class MyDto extends Dto
{
    public function __constructor(
        public string $property1,
        public string $property2 = 'value 2'
    ) {
    }
}

$dtoA = new MyDto(
    property1: 'value 1',
);

$dtoB = new MyDto(
    property1: 'value 1',
    property2: 'other value'
);

echo $dtoA->property2; // print: value 2
echo $dtoA->property2; // print: other value
```

__Nullable Properties__

When a value is not sent to a nullable property it is automatically set to `null`.

```php
use Mate\Dto\Dto;

class MyDto extends Dto
{
    public string $property1;
    public ?string $property2;
}

$dtoA = new MyDto(
    property1: 'value 1',
);

$dtoB = new MyDto(
    property1: 'value 1',
    property2: 'value 2';
);

echo $dtoA->property2; // print: null
echo $dtoB->property2; // print: value 2
```

__Ignored attributes__

You can ignore attributes so that they are not initialized and are not considered.

```php
use Mate\Dto\Dto;
use Mate\Dto\Attributes\Ignored;

class MyDto extends Dto
{
    #[Ignored]
    public string $property1;
    public string $property2;
}

$dto = new MyDto(
    property1: 'value 1',
    property2: 'value 2',
);

echo $dto->property1; // throw: \Error exception
```

## Transforming data

You can convert your DTO to some formats:

__To array__

```php
// ...

$dto = new MyDto(
    property1: 'value 1',
    property2: 'value 2',
);

echo print_r($dto->toArray, true);
// print:
// Array
// (
//     [property1] => value 1
//     [property2] => value 2
// )
```

__To JSON string__

```php
// ...

$dto = new MyDto(
    property1: 'value 1',
    property2: 'value 2',
);

echo print_r($dto->toJson, true);
// print: {"property1":"value 1","property2":"value 2"}
```

__To string__

```php
// ...

$dto = new MyDto(
    property1: 'value 1',
    property2: 'value 2',
);

echo print_r((string) $dto, true);
// print: {"property1":"value 1","property2":"value 2"}
```

# Testing

```sh
composer test

// or with coverage

composer test-coverage
```

# QA Tools

```sh
composer phpcs
composer phpstan
composer phpmd
```

# License

MIT license. Please see the [license file](LICENSE) for more information.
