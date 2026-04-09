# ¿Qué es un DTO?

Un **Objeto de Transferencia de Datos (DTO)** es un objeto diseñado específicamente para transportar datos entre procesos o capas de una aplicación. A diferencia de las entidades o modelos estándar, los DTOs generalmente no contienen lógica de negocio. Su propósito principal es agrupar datos relacionados en un contenedor estructurado y con tipos definidos.

## ¿Por qué usar DTOs?

En el desarrollo moderno de PHP, se prefieren los DTOs frente a los arrays asociativos por varias razones:

*   **🛡️ Seguridad de Tipos**: Cada propiedad tiene un tipo definido. Se acabó el adivinar si `$user['age']` es un string o un entero.
*   **💻 Soporte de IDE**: El autocompletado funciona en todas partes. Ya no es necesario buscar claves de arrays en la documentación o el código fuente.
*   **🔍 Análisis Estático**: Herramientas como PHPStan o Psalm pueden detectar errores incluso antes de ejecutar el código.
*   **🏛️ Encapsulación**: Los DTOs definen un contrato claro de qué datos se esperan, haciendo que el refactoring sea más seguro.
*   **🚀 Rendimiento**: Al usar propiedades de clase en lugar de claves de array dinámicas, el motor de PHP puede optimizar el uso de memoria.
