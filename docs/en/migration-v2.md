# Migration Guide (v1.3.3 to v2.0.0)

Version 2.0.0 is a major refactor of the MatePHP DTO library. This version focuses on high performance for concurrent environments (Swoole) and leverages new PHP 8.4+ features.

## Breaking Changes

### 1. PHP Version Requirement
The minimum PHP version is now **8.4**. This is required to support asymmetric visibility and property hooks.

### 2. Interface Rename
The interface `Mate\Dto\DtoContract` has been removed and replaced by `Mate\Dto\Contracts\DTOInterface`.

**Before:**
```php
use Mate\Dto\DtoContract;

class UserDto implements DtoContract { ... }
```

**After:**
```php
use Mate\Dto\Contracts\DTOInterface;

class UserDto implements DTOInterface { ... }
```

### 3. Removal of "Concern" Traits
All traits under the `Mate\Dto\Concern` namespace have been removed. They were consolidated into two main traits:

- **`Mate\Dto\Traits\Instantiable`**: Handles `fill()`, `fromArray()`, `fromJson()`, etc.
- **`Mate\Dto\Traits\Exportable`**: Handles `toArray()`, `toJson()`, `toDatabase()`, and `JsonSerializable`.

If you were using individual concerns (like `Fill`, `Exports`), you should now use these new traits or simply extend the base `Mate\Dto\Dto` class.

### 4. Removal of Legacy Classes
- `Mate\Dto\Property`: Internal property handling has been completely rewritten using a high-performance `MetadataRegistry`.
- `Mate\Dto\Values\MissingValue`: Direct type and reflection handling now manages defaults.
- `Mate\Dto\Attributes\Ignored`: Use protected/private properties if you want them ignored from public export, or leverage asymmetric visibility.

## New Features & Improvements

### High Performance Metadata
The library now uses a `MetadataRegistry` to cache reflection data. In persistent environments like Swoole, this results in significant performance gains as classes are only analyzed once.

### New Attributes
You can now use declarative attributes to handle complex mapping:

#### MapInputName
Map your input data keys to different property names easily.

```php
use Mate\Dto\Attributes\MapInputName;

class UserDto extends Dto {
    #[MapInputName('user_full_name')]
    public string $name;
}
```

#### Collection
Handle nested DTO arrays with type safety.

```php
use Mate\Dto\Attributes\Collection;

class InvoiceDto extends Dto {
    #[Collection(InvoiceItemDto::class)]
    public array $items;
}
```

### Asymmetric Visibility Support
Version 2 is optimized for PHP 8.4 asymmetric visibility, allowing you to have public read access but private write access.

```php
public private(set) string $id;
```

## Summary of Changes Table

| Legacy (v1.3.3) | New (v2.0.0) |
| :--- | :--- |
| `DtoContract` | `DTOInterface` |
| `src/Concern/` | `src/Traits/Instantiable`, `src/Traits/Exportable` |
| `Property.php` | Internal `MetadataRegistry` |
| `IsFlexible` concern | `#[Flexible]` attribute |
