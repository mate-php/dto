# Instantiation Guide

There are several ways to create a DTO instance, providing flexibility for different data sources and use cases.

## 1. Using the Constructor

The most direct way to instantiate a DTO. It automatically triggers the mapping logic.

```php
$user = new UserDto([
    'firstName' => 'John',
    'lastName' => 'Doe'
]);
```

## 2. Factory Method: `fromArray()`

A semantic alternative to the constructor, useful for static analysis and consistency.

```php
$user = UserDto::fromArray([
    'firstName' => 'Jane',
    'lastName' => 'Doe'
]);
```

## 3. Factory Method: `fromJson()`

Instantiates a DTO directly from a JSON string. Uses `JSON_THROW_ON_ERROR` for safety.

```php
$json = '{"firstName": "John", "lastName": "Doe"}';
$user = UserDto::fromJson($json);
```

## 4. Factory Method: `fromObject()`

Converts any `stdClass` or plain object into a DTO.

```php
$obj = (object) ['firstName' => 'John', 'lastName' => 'Doe'];
$user = UserDto::fromObject($obj);
```

## 5. Factory Method: `fromDto()`

Clones data from another DTO instance. Useful for transforming one DTO type to another if they share property names.

```php
$otherDto = new MemberDto(['firstName' => 'John']);
$user = UserDto::fromDto($otherDto);
```

## 6. Updating Existing Instance: `fill()`

Reuses an existing DTO instance by updating its properties. Returns `$this` to allow method chaining.

```php
$user = new UserDto();
$user->fill(['firstName' => 'Updated Name'])
     ->fill(['lastName' => 'New Last Name']);
```

## 7. Constructor Property Promotion

You can use native PHP promotion for manual instantiation while keeping DTO capabilities.

```php
class UserDto extends Dto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public int $age = 18
    ) {
        parent::__construct();
    }
}

// Manual call still works
$user = new UserDto(firstName: 'John', lastName: 'Doe');
```

---

## Mapping Logic Details

When you use any of the above methods, the library:
1.  **Resolves Metadata**: Reads property names, types, and attributes (cached).
2.  **Maps Keys**: Looks for keys matching the property name (e.g., `firstName`) or its snake_case version (`first_name`).
3.  **Handles Attributes**: Respects `#[MapInputName]`, `#[Collection]`, and `#[Flexible]`.
4.  **Type Validation**: Ensures the input value matches the property type, throwing `InvalidDataException` on mismatch.
