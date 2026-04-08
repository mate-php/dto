<?php

declare(strict_types=1);

namespace Mate\Dto\Contracts;

/**
 * Interface DTOInterface
 * Contract for Data Transfer Objects.
 */
interface DTOInterface extends \JsonSerializable, \ArrayAccess, \Stringable
{
    /**
     * Factory method to create a DTO from an array.
     */
    public static function fromArray(array $data): static;

    /**
     * Factory method to create a DTO from an object.
     */
    public static function fromObject(object $data): static;

    /**
     * Factory method to create a DTO from a JSON string.
     */
    public static function fromJson(string $json): static;

    /**
     * Factory method to create a DTO from another DTO.
     */
    public static function fromDto(DTOInterface $dto): static;

    /**
     * Exports the DTO to an array.
     */
    public function toArray(): array;

    /**
     * Exports the DTO to a format suitable for database persistence.
     */
    public function toDatabase(): array;

    /**
     * Exports the DTO to a JSON string.
     */
    public function toJson(): string;
}
