# Guía de Instanciación

Existen varias formas de crear una instancia de un DTO, ofreciendo flexibilidad para diferentes fuentes de datos y casos de uso.

## 1. Usando el Constructor

La forma más directa de instanciar un DTO. Activa automáticamente la lógica de mapeo.

```php
$user = new UserDto([
    'firstName' => 'John',
    'lastName' => 'Doe'
]);
```

## 2. Método Factory: `fromArray()`

Una alternativa semántica al constructor, útil para el análisis estático y la consistencia.

```php
$user = UserDto::fromArray([
    'firstName' => 'Jane',
    'lastName' => 'Doe'
]);
```

## 3. Método Factory: `fromJson()`

Instancia un DTO directamente desde una cadena JSON. Utiliza `JSON_THROW_ON_ERROR` para mayor seguridad.

```php
$json = '{"firstName": "John", "lastName": "Doe"}';
$user = UserDto::fromJson($json);
```

## 4. Método Factory: `fromObject()`

Convierte cualquier `stdClass` u objeto plano en un DTO.

```php
$obj = (object) ['firstName' => 'John', 'lastName' => 'Doe'];
$user = UserDto::fromObject($obj);
```

## 5. Método Factory: `fromDto()`

Clona los datos desde otra instancia de DTO. Útil para transformar un tipo de DTO a otro si comparten nombres de propiedades.

```php
$otherDto = new MemberDto(['firstName' => 'John']);
$user = UserDto::fromDto($otherDto);
```

## 6. Actualización de Instancia: `fill()`

Reutiliza una instancia de DTO existente actualizando sus propiedades. Devuelve `$this` para permitir el encadenamiento de métodos.

```php
$user = new UserDto();
$user->fill(['firstName' => 'Nombre Actualizado'])
     ->fill(['lastName' => 'Nuevo Apellido']);
```

## 7. Promoción de Propiedades en Constructor

Puedes usar la promoción nativa de PHP para la instanciación manual manteniendo las capacidades del DTO.

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

// La llamada manual sigue funcionando
$user = new UserDto(firstName: 'John', lastName: 'Doe');
```

---

## Detalles de la Lógica de Mapeo

Cuando utilizas cualquiera de los métodos anteriores, la librería:
1.  **Resuelve Metadatos**: Lee los nombres de las propiedades, tipos y atributos (en caché).
2.  **Mapea Claves**: Busca claves que coincidan con el nombre de la propiedad (ej. `firstName`) o su versión en snake_case (`first_name`).
3.  **Maneja Atributos**: Respeta `#[MapInputName]`, `#[Collection]` y `#[Flexible]`.
4.  **Validación de Tipos**: Asegura que el valor de entrada coincida con el tipo de la propiedad, lanzando `InvalidDataException` en caso de discrepancia.
