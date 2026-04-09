<p align="center">
  <img src="docs/assets/mate-logo.png" width="200" alt="Mate/dto Logo">
</p>

<h1 align="center">Mate/dto</h1>

<p align="center">
  <strong>High-performance, modern and framework-agnostic DTO library for PHP 8.4+.</strong>
</p>


[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/mate-php/dto)
[![Latest Stable Version](https://img.shields.io/packagist/v/matephp/dto)](https://packagist.org/packages/matephp/dto)
[![Unstable Version](https://img.shields.io/badge/unstable-dev--main-orange)](https://github.com/mate-php/dto)
[![PHP Version](https://img.shields.io/badge/php-8.4%2B-indigo.svg)](https://github.com/mate-php/dto/blob/main/composer.json)
[![Total Downloads](https://img.shields.io/packagist/dt/matephp/dto)](https://packagist.org/packages/matephp/dto)
[![License](https://img.shields.io/packagist/l/matephp/dto)](https://github.com/mate-php/dto/blob/main/LICENSE)
[![Hits-of-Code](https://hitsofcode.com/github/mate-php/dto?branch=main)](https://hitsofcode.com/github/mate-php/dto/json?branch=main)
[![Coverage](https://img.shields.io/badge/coverage-100%25-green.svg)](https://github.com/mate-php/dto/tree/main/tests)


---

## 🚀 Overview

**Mate/dto** is a lightweight, zero-dependency (almost) core component designed to be **completely framework-agnostic**. It leverages modern PHP 8.4 features like **Asymmetric Visibility** and **Constructor Property Promotion** to provide a developer-friendly API with maximum performance.

## 📦 Installation

Install the library via Composer:

```bash
composer require mate-php/dto
```

## 📖 Quick Start

Define your DTO using standard PHP properties and asymmetric visibility for better encapsulation:

```php
use Mate\Dto\Dto;

class UserDto extends Dto
{
    public private(set) string $name;
    public private(set) int $age;
    public ?string $email = null;
}

// Instantiate from an array
$user = new UserDto([
    'name' => 'John Doe',
    'age' => 30,
    'email' => 'john.doe@example.com'
]);

echo $user->name; // John Doe
echo $user->toJson();
```

## 📚 Full Documentation

For advanced features like **Collections**, **Custom Mapping**, **Strict Mode**, and **Benchmarks**, please visit our full documentation site:

👉 **[https://mate-php.github.io/dto/](https://mate-php.github.io/dto/)**

---

Made with ❤️ by the **MatePHP** Team.
