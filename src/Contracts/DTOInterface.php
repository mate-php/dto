<?php

declare(strict_types=1);

namespace Mate\Dto\Contracts;

/**
 * Interface DTOInterface
 * Contract for Data Transfer Objects.
 *
 * @extends \ArrayAccess<string, mixed>
 */
interface DTOInterface extends \JsonSerializable, \ArrayAccess, \Stringable
{
    /**
     * Factory method to create a DTO from an array.
     *
     * @param array<string, mixed> $data
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
     * Fills the DTO with the given array data.
     *
     * @param array<string, mixed> $data
     */
    public function fill(array $data): static;

    /**
     * Exports the DTO to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * Exports the DTO to a format suitable for database persistence.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(): array;

    /**
     * Exports the DTO to a JSON string.
     */
    public function toJson(): string;
}
