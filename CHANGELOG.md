# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-04-14

### Added
- **Attributes System**: Introduced new declarative attributes for mapping and collection handling.
    - `#[MapInputName]`: Map incoming data keys to specific class properties.
    - `#[Collection]`: Define typed collections for nested DTO array instantiation.
    - `#[Flexible]`: Control whether a DTO can accept unknown properties.
- **High-Performance Metadata**: Added `MetadataRegistry` and `PropertyMetadata` to cache reflection data.
- **Instantiable Trait**: New logic for object industrialization using `fromArray`, `fromJson`, `fromObject`, and `fromDto`.
- **Exportable Trait**: Standardized methods for exporting to `toArray`, `toJson`, and `toDatabase` formats.
- **Helper Utilities**: Added `Mate\Dto\Support\Helper` for case conversions (snake_case/camelCase).
- **PHP 8.4 Support**: Optimized for Asymmetric Visibility and modern property handling.

### Changed
- **Architecture Refactor**: Replaced multiple "Concern" traits (`Fill`, `Exports`, `From`, etc.) with consolidated `Instantiable` and `Exportable` traits.
- **Main Interface**: Replaced `DtoContract` with `Mate\Dto\Contracts\DTOInterface`.
- **Dto Base Class**: Refactored `Mate\Dto\Dto` to be a lightweight container using the new traits and metadata registry.
- **ArrayAccess Implementation**: Internal improvement of `ArrayAccess` methods to directly interact with property metadata.

### Removed
- **Legacy Concerns**: Removed all files under `src/Concern/` (`ArrayAccessMethods.php`, `Exports.php`, `Fill.php`, `From.php`, `IsFlexible.php`).
- **Property Class**: Removed `src/Property.php` as its logic was merged into the metadata system.
- **Attributes**: Removed `src/Attributes/Ignored.php`.
- **MissingValue**: Removed `src/Values/MissingValue.php`.
- **Legacy Contract**: Removed `src/DtoContract.php`.

## [1.3.3] - 2026-04-10

### Fixed
- Maintenance and stability fixes for the legacy trait-based architecture.

[2.0.0]: https://github.com/MatePHP/dto/compare/1.3.3...2.0.0
[1.3.3]: https://github.com/MatePHP/dto/releases/tag/1.3.3
