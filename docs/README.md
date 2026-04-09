# MatePHP - DTO Library

> High-performance, low-latency, and modern Data Transfer Object library for **PHP 8.4+**. **Framework Agnostic** by design.

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/mate-php/dto)
[![Latest Stable Version](https://img.shields.io/packagist/v/matephp/dto)](https://packagist.org/packages/matephp/dto)
[![Unstable Version](https://img.shields.io/badge/unstable-dev--main-orange)](https://github.com/mate-php/dto)
[![PHP Version](https://img.shields.io/badge/php-8.4%2B-indigo.svg)](https://github.com/mate-php/dto/blob/main/composer.json)
[![Total Downloads](https://img.shields.io/packagist/dt/matephp/dto)](https://packagist.org/packages/matephp/dto)
[![License](https://img.shields.io/packagist/l/matephp/dto)](https://github.com/mate-php/dto/blob/main/LICENSE)
[![Hits-of-Code](https://hitsofcode.com/github/mate-php/dto?branch=main)](https://hitsofcode.com/github/mate-php/dto/json?branch=main)
[![Coverage](https://img.shields.io/badge/coverage-100%25-green.svg)](https://github.com/mate-php/dto/tree/main/tests)

---

## Overview

**Mate/dto** is a lightweight, zero-dependency (almost) core component designed to be **completely framework-agnostic**. It leverages modern PHP 8.4 features to provide a developer-friendly API with maximum performance.

### Key Features

*   **⚡ High Performance**: Optimized mapping engine with metadata caching.
*   **💎 PHP 8.4 Support**: Native support for **Asymmetric Visibility** (`public private(set)`) and Property Promotion.
*   **🪐 Agnostic & Flexible**: Works with any framework or custom application.
*   **🛠️ Flexible & Strict**: Choose between strict validation or flexible data mapping using attributes.
*   **📦 Zero Redundancy**: Optimized instantiation logic to minimize overhead.

---

## Installation

```bash
composer require mate-php/dto
```

---

## Quick Start

### Simple DTO

```php
use Mate\Dto\Dto;

class UserDto extends Dto
{
    public private(set) string $name;
    public private(set) int $age;
    public ?string $email = null;
}

$dto = new UserDto([
    'name' => 'John Doe',
    'age' => 30,
    'email' => 'john.doe@example.com'
]);

echo $dto->name; // John Doe
echo $dto->toJson();
```

### Nesting & Collections

```php
use Mate\Dto\Dto;
use Mate\Dto\Attributes\Collection;

class OrderDto extends Dto
{
    public string $orderId;
    
    #[Collection(ItemDto::class)]
    public array $items;
}
```

---

## Exception System

The library provides a robust exception hierarchy for better error handling:

*   `Mate\Dto\Exceptions\InvalidDataException`: Thrown on type mismatches.
*   `Mate\Dto\Exceptions\NotFlexibleException`: Thrown when unknown data is passed to a strict DTO.

---

Made with ❤️ by the **MatePHP** Team.
