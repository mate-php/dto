# Best Practices Guide

To get the most out of **Mate/dto**, we recommend following these modern PHP 8.4 patterns.

## 🪐 Asymmetric Visibility (Modern Approach)

In PHP 8.4+, you can define properties that are **publicly readable** but **privately writable**. This is the modern replacement for traditional getters and setters in DTOs.

```php
abstract class UserDto extends Dto
{
    // Use public private(set) for better encapsulation
    public private(set) string $name;
    public private(set) int $age;
}
```

> [!TIP]
> **Why use this?**: It maintains perfect immutability from the outside while allowing the library's internal mapping engine (which uses reflection) to set values correctly.

## 🧱 Immutability with `readonly`

While `private(set)` is great for DTOs that might be initialized and then exported, if your DTO is truly immutable after its creation, use `readonly`.

```php
readonly class UserDto extends Dto
{
    public string $name;
    public int $age;
}
```

## 🛠️ Handling Unknown Data

By default, DTOs are **Flexible** (they ignore unknown keys in the input array). For strict APIs, use the `#[Flexible]` attribute.

```php
use Mate\Dto\Attributes\Flexible;

#[Flexible(enabled: false)]
class StrictDto extends Dto
{
    public string $name;
}

// This will throw NotFlexibleException if 'age' is passed
$dto = new StrictDto(['name' => 'John', 'age' => 30]);
```

## ⚡ Concurrency & State Management

Mate/dto is designed for high-performance and persistent environments (such as FPM, RoadRunner, or Swoole).

*   **Stateless Core**: Each DTO instance is its own world. There are no static properties holding data, making it safe for concurrent requests.
*   **Reuse DTOs**: In high-concurrency scenarios, you can reuse DTO instances by using `$dto->fill($data)` to avoid GC overhead.
*   **Metadata Caching**: The metadata registry automatically caches property reflections, making subsequent instantiations much faster.

## 🏗️ Naming Conventions

*   **Properties**: Use `camelCase` for properties (`firstName`).
*   **Mapped Names**: Use `#[MapInputName]` if your input source uses a different naming convention (e.g., `user_first_name`).
*   **Database**: The library automatically handles `snake_case` conversion when you use `toDatabase()`.

---

## 🛡️ Error Handling

Always wrap DTO instantiation in a try-catch block for production to handle potential mapping errors gracefully:

```php
try {
    $dto = UserDto::fromArray($data);
} catch (InvalidDataException $e) {
    // Handle type mismatches or missing data
    $logger->error($e->getMessage());
} catch (NotFlexibleException $e) {
    // Handle unexpected data keys in strict DTOs
}
```
