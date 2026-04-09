# Exporting & Serialization

MatePHP DTOs provide multiple ways to extract and serialize data for different use cases (Database, JSON, Arrays).

## 1. Export as Array: `toArray()`

The standard way to export a DTO as a plain associative array. Useful for template rendering or internal processing.

```php
$user = new UserDto(['firstName' => 'John', 'lastName' => 'Doe']);
$array = $user->toArray();
// [ 'firstName' => 'John', 'lastName' => 'Doe' ]
```

## 2. Database format: `toDatabase()`

Automatically converts all keys to `snake_case`. Ideal for direct database insertion.

```php
$user = new UserDto(['firstName' => 'John', 'lastName' => 'Doe']);
$dbData = $user->toDatabase();
// [ 'first_name' => 'John', 'last_name' => 'Doe' ]
```

## 3. JSON Export: `toJson()`

Returns the DTO as a JSON string. Uses `JSON_UNESCAPED_UNICODE` for better readability.

```php
$json = $user->toJson();
// {"firstName":"John","lastName":"Doe"}
```

## 4. Automatic JSON Support: `jsonSerialize()`

Since `Dto` implements `JsonSerializable`, you can simply use `json_encode()` on any instance.

```php
$json = json_encode($user);
// {"firstName":"John","lastName":"Doe"}
```

## 5. String Casting: `__toString()`

The DTO will return its JSON representation when cast to a string or used in a string context.

```php
echo (string) $user;
// {"firstName":"John","lastName":"Doe"}
```

## 6. Access as Array: `ArrayAccess`

You can access or set DTO properties as if the object were an array, while maintaining type safety and validation.

```php
$user = new UserDto();
$user['firstName'] = 'John';
echo $user['firstName']; // John
```

---

## Nested Exports

When you export a DTO that contains nested DTOs or collections of DTOs, the library **recursively** converts all child DTOs to arrays.

```php
class ProfileDto extends Dto
{
    public string $name;
    public AddressDto $address;
}

$profile = new ProfileDto([...]);
print_r($profile->toArray());
/*
Array
(
    [name] => John
    [address] => Array
        (
            [city] => NY
            [street] => 5th Ave
        )
)
*/
```
