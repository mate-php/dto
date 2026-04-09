# Exportación y Serialización

La librería ofrecen múltiples formas de extraer y serializar datos para diferentes casos de uso (Base de Datos, JSON, Arrays).

## 1. Exportar como Array: `toArray()`

La forma estándar de exportar un DTO como un array asociativo plano. Útil para renderizado de plantillas o procesamiento interno.

```php
$user = new UserDto(['firstName' => 'John', 'lastName' => 'Doe']);
$array = $user->toArray();
// [ 'firstName' => 'John', 'lastName' => 'Doe' ]
```

## 2. Formato para Base de Datos: `toDatabase()`

Convierte automáticamente todas las claves a `snake_case`. Ideal para la inserción directa en bases de datos.

```php
$user = new UserDto(['firstName' => 'John', 'lastName' => 'Doe']);
$dbData = $user->toDatabase();
// [ 'first_name' => 'John', 'last_name' => 'Doe' ]
```

## 3. Exportación a JSON: `toJson()`

Devuelve el DTO como una cadena JSON. Utiliza `JSON_UNESCAPED_UNICODE` para una mejor legibilidad.

```php
$json = $user->toJson();
// {"firstName":"John","lastName":"Doe"}
```

## 4. Soporte Automático de JSON: `jsonSerialize()`

Dado que `Dto` implementa `JsonSerializable`, simplemente puedes usar `json_encode()` en cualquier instancia.

```php
$json = json_encode($user);
// {"firstName":"John","lastName":"Doe"}
```

## 5. Casting a String: `__toString()`

El DTO devolverá su representación JSON cuando se convierta a una cadena o se use en un contexto de cadena.

```php
echo (string) $user;
// {"firstName":"John","lastName":"Doe"}
```

## 6. Acceso como Array: `ArrayAccess`

Puedes acceder o establecer propiedades del DTO como si el objeto fuera un array, manteniendo la seguridad de tipos y la validación.

```php
$user = new UserDto();
$user['firstName'] = 'John';
echo $user['firstName']; // John
```

---

## Exportaciones Anidadas

Cuando exportas un DTO que contiene otros DTOs anidados o colecciones de DTOs, la librería convierte **recursivamente** todos los DTOs hijos a arrays.

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
