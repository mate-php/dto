# What is a DTO?

A **Data Transfer Object (DTO)** is an object designed specifically to carry data between processes or layers of an application. Unlike standard entities or models, DTOs usually don't contain business logic. Their primary purpose is to group related data into a structured, type-safe container.

## Why use DTOs?

In modern PHP development, DTOs are preferred over associative arrays for several reasons:

*   **🛡️ Type Safety**: Every property has a defined type. No more guessing if `$user['age']` is a string or an integer.
*   **💻 IDE Support**: Autocomplete works everywhere. No more looking up array keys in documentation or source code.
*   **🔍 Static Analysis**: Tools like PHPStan or Psalm can catch errors before you даже run the code.
*   **🏛️ Encapsulation**: DTOs define a clear contract for what data is expected, making refactoring safer.
*   **🚀 Performance**: By using class properties instead of dynamic array keys, the engine can optimize memory usage.