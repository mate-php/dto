# Attributes Guide

The library uses PHP 8.0+ Attributes to provide fine-grained control over how data is mapped and validated.

## `#[MapInputName]`

Used to map a specific key from the input array to a property name. By default, the library looks for a key matching the property name or its `snake_case` version.

### Usage
```php
use Mate\Dto\Attributes\MapInputName;

class UserDto extends Dto
{
    #[MapInputName('user_full_name')]
    public string $name;
}

// Maps input ['user_full_name' => 'John'] to $dto->name
```

---

## `#[Collection]`

Crucial for handling nested DTO arrays. Since PHP arrays don't natively support generics, this attribute tells the mapper which DTO class to use for each item in the array.

### Usage
```php
use Mate\Dto\Attributes\Collection;

class OrderDto extends Dto
{
    #[Collection(ItemDto::class)]
    public array $items;
}

// Automatically converts each item in 'items' array into an ItemDto instance.
```

---

## `#[Flexible]`

Controls the strictness of the DTO mapping. By default, DTOs are **Flexible** (they ignore unknown keys). You can apply this attribute at the class level to enable **Strict Mode**.

### Usage
```php
use Mate\Dto\Attributes\Flexible;

#[Flexible(enabled: false)]
class StrictUserDto extends Dto
{
    public string $name;
}

// Throws NotFlexibleException if input contains keys other than 'name'.
```

> [!TIP]
> **Performance**: Attributes are read once and cached in the internal metadata registry, so they have zero impact on performance during subsequent instantiations.
