<?php

declare(strict_types=1);

namespace Mate\Dto\Exceptions;

/**
 * Thrown when unknown properties are passed to a non-flexible DTO.
 */
class NotFlexibleException extends DtoException
{
}
