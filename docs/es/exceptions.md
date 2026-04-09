# Sistema de Excepciones

MatePHP DTO proporciona una jerarquía clara de excepciones personalizadas para ayudarte a manejar los errores de mapeo de datos de forma elegante.

## Excepción Base

### `Mate\Dto\Exceptions\DtoException`
La clase base para todas las excepciones lanzadas por la librería. Al capturar esta excepción, capturarás todos los errores específicos de la librería.

---

## Excepciones Detalladas

### `Mate\Dto\Exceptions\InvalidDataException`
Se lanza cuando el tipo de datos de entrada no coincide con el tipo de la propiedad.

*   **Cuándo ocurre**: Mapear un string a una propiedad `int`, o un array mal formado a una colección de DTOs.
*   **Resolución**: Verifica los datos de origen o proporciona un tipo más flexible (como un tipo de unión) en el DTO.

### `Mate\Dto\Exceptions\NotFlexibleException`
Se lanza cuando un DTO con mapeo estricto (`#[Flexible(enabled: false)]`) recibe claves desconocidas en los datos de entrada.

*   **Cuándo ocurre**: Pasar `['name' => 'John', 'campo_desconocido' => 123]` a un DTO estricto.
*   **Resolución**: Elimina los campos adicionales de la entrada o habilita la flexibilidad en el DTO.

---

## Mejores Prácticas para el Manejo de Errores

Siempre envuelve la instanciación de tus DTOs en un bloque try-catch para ofrecer una respuesta clara a tus usuarios de la API o registrar los errores adecuadamente.

```php
try {
    $user = UserDto::fromArray($requestData);
} catch (InvalidDataException $e) {
    // 422 Unprocessable Entity
    return ['error' => 'Datos inválidos proporcionados: ' . $e->getMessage()];
} catch (NotFlexibleException $e) {
    // 400 Bad Request
    return ['error' => 'Se detectaron campos desconocidos.'];
} catch (DtoException $e) {
    // Error General de la Librería
    return ['error' => 'Ocurrió un error inesperado en el mapeo del DTO.'];
}
```
