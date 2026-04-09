# Guía de Mejores Prácticas

Para sacar el máximo provecho de **Mate/dto**, recomendamos seguir estos patrones modernos de PHP 8.4.

## 🪐 Visibilidad Asimétrica (Enfoque Moderno)

En PHP 8.4+, puedes definir propiedades que son **públicamente legibles** pero **privadamente escribibles**. Este es el reemplazo moderno para los tradicionales getters y setters en los DTOs.

```php
abstract class UserDto extends Dto
{
    // Usa public private(set) para una mejor encapsulación
    public private(set) string $name;
    public private(set) int $age;
}
```

> [!TIP]
> **¿Por qué usar esto?**: Mantiene una inmutabilidad perfecta desde el exterior mientras permite que el motor de mapeo interno de la librería (que usa reflexión) establezca los valores correctamente.

## 🧱 Inmutabilidad con `readonly`

Aunque `private(set)` es excelente para DTOs que podrían ser inicializados y luego exportados, si tu DTO es verdaderamente inmutable después de su creación, utiliza `readonly`.

```php
readonly class UserDto extends Dto
{
    public string $name;
    public int $age;
}
```

## 🛠️ Manejo de Datos Desconocidos

Por defecto, los DTOs son **Flexibles** (ignoran las claves desconocidas en el array de entrada). Para APIs estrictas, utiliza el atributo `#[Flexible]`.

```php
use Mate\Dto\Attributes\Flexible;

#[Flexible(enabled: false)]
class StrictDto extends Dto
{
    public string $name;
}

// Esto lanzará NotFlexibleException si se pasa 'age'
$dto = new StrictDto(['name' => 'John', 'age' => 30]);
```

## ⚡ Concurrencia y Gestión de Estado

Mate/dto está diseñado para entornos de alto rendimiento y persistentes (como FPM, RoadRunner o Swoole).

*   **Núcleo sin Estado (Stateless)**: Cada instancia de DTO es su propio mundo. No hay propiedades estáticas manteniendo datos, lo que lo hace seguro para peticiones concurrentes.
*   **Reutilización de DTOs**: En escenarios de alta concurrencia, puedes reutilizar instancias de DTO usando `$dto->fill($data)` para evitar la sobrecarga del recolector de basura (GC).
*   **Caché de Metadatos**: El registro de metadatos almacena automáticamente las reflexiones de las propiedades, haciendo que las instanciaciones subsiguientes sean mucho más rápidas.

## 🏗️ Convenciones de Nomenclatura

*   **Propiedades**: Usa `camelCase` para las propiedades (`firstName`).
*   **Nombres Mapeados**: Usa `#[MapInputName]` si tu fuente de entrada utiliza una convención de nomenclatura diferente (ej. `user_first_name`).
*   **Base de Datos**: La librería maneja automáticamente la conversión a `snake_case` cuando utilizas `toDatabase()`.

---

## 🛡️ Manejo de Errores

Siempre envuelve la instanciación del DTO en un bloque try-catch en producción para manejar los posibles errores de mapeo con elegancia:

```php
try {
    $dto = UserDto::fromArray($data);
} catch (InvalidDataException $e) {
    // Maneja discrepancias de tipos o datos faltantes
    $logger->error($e->getMessage());
} catch (NotFlexibleException $e) {
    // Maneja claves de datos inesperadas en DTOs estrictos
}
```
