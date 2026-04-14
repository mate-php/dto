# Guía de Migración (v1.3.3 a v2.0.0)

La versión 2.0.0 es una refactorización mayor de la librería MatePHP DTO. Esta versión se enfoca en el alto rendimiento para entornos concurrentes (Swoole) y aprovecha las nuevas características de PHP 8.4+.

## Cambios Rompibles (Breaking Changes)

### 1. Requisito de Versión de PHP
La versión mínima de PHP es ahora **8.4**. Esto es necesario para soportar la visibilidad asimétrica y los *property hooks*.

### 2. Renombrado de Interfaz
Se ha eliminado la interfaz `Mate\Dto\DtoContract` y se ha reemplazado por `Mate\Dto\Contracts\DTOInterface`.

**Antes:**
```php
use Mate\Dto\DtoContract;

class UserDto implements DtoContract { ... }
```

**Después:**
```php
use Mate\Dto\Contracts\DTOInterface;

class UserDto implements DTOInterface { ... }
```

### 3. Eliminación de Traits de "Concern"
Se han eliminado todos los traits bajo el namespace `Mate\Dto\Concern`. Se han consolidado en dos traits principales:

- **`Mate\Dto\Traits\Instantiable`**: Maneja `fill()`, `fromArray()`, `fromJson()`, etc.
- **`Mate\Dto\Traits\Exportable`**: Maneja `toArray()`, `toJson()`, `toDatabase()`, y `JsonSerializable`.

Si estabas usando concerns individuales (como `Fill`, `Exports`), ahora deberías usar estos nuevos traits o simplemente extender la clase base `Mate\Dto\Dto`.

### 4. Eliminación de Clases
- `Mate\Dto\Property`: El manejo interno de propiedades se ha reescrito completamente usando un sistema de alto rendimiento llamado `MetadataRegistry`.
- `Mate\Dto\Values\MissingValue`: El manejo directo de tipos y reflexión ahora gestiona los valores predeterminados.
- `Mate\Dto\Attributes\Ignored`: Usa propiedades `protected`/`private` si quieres que se ignoren en la exportación pública, o aprovecha la visibilidad asimétrica.

## Nuevas Características y Mejoras

### Metadatos de Alto Rendimiento
La librería utiliza ahora un `MetadataRegistry` para cachear los datos de reflexión. En entornos persistentes como Swoole, esto resulta en ganancias significativas de rendimiento, ya que las clases solo se analizan una vez.

### Nuevos Atributos
Ahora puedes usar atributos declarativos para manejar mapeos complejos:

#### MapInputName
Mapea las claves de tus datos de entrada a nombres de propiedades de forma sencilla.

```php
use Mate\Dto\Attributes\MapInputName;

class UserDto extends Dto {
    #[MapInputName('nombre_completo_usuario')]
    public string $name;
}
```

#### Collection
Maneja arrays de DTOs anidados con seguridad de tipos.

```php
use Mate\Dto\Attributes\Collection;

class InvoiceDto extends Dto {
    #[Collection(InvoiceItemDto::class)]
    public array $items;
}
```

### Soporte para Visibilidad Asimétrica
La versión 2 está optimizada para la visibilidad asimétrica de PHP 8.4, lo que te permite tener acceso de lectura público pero acceso de escritura privado.

```php
public private(set) string $id;
```

## Tabla de Resumen de Cambios

| Legado (v1.3.3) | Nuevo (v2.0.0) |
| :--- | :--- |
| `DtoContract` | `DTOInterface` |
| `src/Concern/` | `src/Traits/Instantiable`, `src/Traits/Exportable` |
| `Property.php` | `MetadataRegistry` interno |
| Concern `IsFlexible` | Atributo `#[Flexible]` |
