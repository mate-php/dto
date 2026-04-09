# MatePHP - DTO Library

> Librería de Objetos de Transferencia de Datos (DTO) de alto rendimiento, baja latencia y moderna para **PHP 8.4+**. **Agnóstica a frameworks** por diseño.

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/mate-php/dto)
[![Latest Stable Version](https://img.shields.io/packagist/v/matephp/dto)](https://packagist.org/packages/matephp/dto)
[![Unstable Version](https://img.shields.io/badge/unstable-dev--main-orange)](https://github.com/mate-php/dto)
[![PHP Version](https://img.shields.io/badge/php-8.4%2B-indigo.svg)](https://github.com/mate-php/dto/blob/main/composer.json)
[![Total Downloads](https://img.shields.io/packagist/dt/matephp/dto)](https://packagist.org/packages/matephp/dto)
[![License](https://img.shields.io/packagist/l/matephp/dto)](https://github.com/mate-php/dto/blob/main/LICENSE)
[![Hits-of-Code](https://hitsofcode.com/github/mate-php/dto?branch=main)](https://hitsofcode.com/github/mate-php/dto/json?branch=main)
[![Coverage](https://img.shields.io/badge/coverage-100%25-green.svg)](https://github.com/mate-php/dto/tree/main/tests)

---

## Vista General

**Mate/dto** es un componente ligero y sin dependencias diseñado para ser **completamente agnóstico a frameworks**. Utiliza las características más modernas de PHP 8.4 para ofrecer una API amigable para el desarrollador con el máximo rendimiento.

### Características Principales

*   **⚡ Alto Rendimiento**: Motor de mapeo optimizado con caché de metadatos.
*   **💎 Soporte PHP 8.4**: Soporte nativo para **Visibilidad Asimétrica** (`public private(set)`) y Promoción de Propiedades.
*   **🪐 Agnóstica y Flexible**: Funciona con cualquier framework o aplicación personalizada.
*   **🛠️ Flexible y Estricto**: Elige entre validación estricta o mapeo flexible de datos mediante atributos.
*   **📦 Cero Redundancia**: Lógica de instanciación optimizada para minimizar la sobrecarga.

---

## Instalación

```bash
composer require mate-php/dto
```

---

## Quick Start

### DTO Simple

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

### Anidación y Colecciones

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

## Sistema de Excepciones

La librería proporciona una jerarquía de excepciones robusta para un mejor manejo de errores:

*   `Mate\Dto\Exceptions\InvalidDataException`: Se lanza en caso de discrepancias de tipo.
*   `Mate\Dto\Exceptions\NotFlexibleException`: Se lanza cuando se pasan datos desconocidos a un DTO estricto.

---

Made with ❤️ by the **MatePHP** Team.
