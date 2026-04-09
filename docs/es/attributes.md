# Guía de Atributos

La librería utiliza Atributos de PHP 8.0+ para ofrecer un control granular sobre cómo se mapean y validan los datos.

## `#[MapInputName]`

Se utiliza para mapear una clave específica del array de entrada a una propiedad. Por defecto, la librería busca una clave que coincida con el nombre de la propiedad o su versión en `snake_case`.

### Uso
```php
use Mate\Dto\Attributes\MapInputName;

class UserDto extends Dto
{
    #[MapInputName('user_full_name')]
    public string $name;
}

// Mapea la entrada ['user_full_name' => 'John'] a $dto->name
```

---

## `#[Collection]`

Fundamental para manejar arrays de DTOs anidados. Dado que los arrays de PHP no soportan genéricos de forma nativa, este atributo indica al mapeador qué clase de DTO debe usar para cada elemento del array.

### Uso
```php
use Mate\Dto\Attributes\Collection;

class OrderDto extends Dto
{
    #[Collection(ItemDto::class)]
    public array $items;
}

// Convierte automáticamente cada elemento en el array 'items' en una instancia de ItemDto.
```

---

## `#[Flexible]`

Controla la rigurosidad del mapeo del DTO. Por defecto, los DTOs son **Flexibles** (ignoran claves desconocidas). Puedes aplicar este atributo a nivel de clase para activar el **Modo Estricto**.

### Uso
```php
use Mate\Dto\Attributes\Flexible;

#[Flexible(enabled: false)]
class StrictUserDto extends Dto
{
    public string $name;
}

// Lanza una NotFlexibleException si la entrada contiene claves distintas a 'name'.
```

> [!TIP]
> **Rendimiento**: Los atributos se leen una sola vez y se almacenan en el registro interno de metadatos, por lo que tienen un impacto nulo en el rendimiento durante instanciaciones subsiguientes.
