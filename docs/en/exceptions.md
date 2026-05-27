# Exception System

MatePHP DTO provides a clear hierarchy of custom exceptions to help you handle data mapping errors gracefully.

## Base Exception

### `Mate\Dto\Exceptions\DtoException`
The base class for all exceptions thrown by the library. Catching this will capture all library-specific errors.

---

## Detailed Exceptions

### `Mate\Dto\Exceptions\InvalidDataException`
Thrown when the input data type does not match the property type.

*   **When it happens**: Mapping a string to an `int` property, or a malformed array to a DTO collection.
*   **Resolution**: Verify the source data or provide a more flexible type (like a union type) in the DTO.

### `Mate\Dto\Exceptions\NotFlexibleException`
Thrown when a DTO with strict mapping (`#[Flexible(enabled: false)]`) receives unknown keys in the input data.

*   **When it happens**: Passing `['name' => 'John', 'unknown_field' => 123]` to a strict DTO.
*   **Resolution**: Remove the extra fields from the input or enable flexibility on the DTO.

---

## Best Practices for Error Handling

Always wrap your DTO instantiation in a try-catch block to provide clean feedback to your API users or log the errors properly.

```php
try {
    $user = UserDto::fromArray($requestData);
} catch (InvalidDataException $e) {
    // 422 Unprocessable Entity
    return ['error' => 'Invalid data provided: ' . $e->getMessage()];
} catch (NotFlexibleException $e) {
    // 400 Bad Request
    return ['error' => 'Unknown fields detected.'];
} catch (DtoException $e) {
    // General Library Error
    return ['error' => 'An unexpected error occurred in DTO mapping.'];
}
```
