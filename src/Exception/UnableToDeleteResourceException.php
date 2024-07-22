<?php

declare(strict_types=1);

namespace App\Exception;

use DomainException;

use function sprintf;

final class UnableToDeleteResourceException extends DomainException
{
    public static function deleteFromClassAndId(string $class, string $id): self
    {
        return new UnableToDeleteResourceException(sprintf('Resource of type [%s] with ID [%s] cannot be deleted', $class, $id));
    }

    public static function deleteLastFromClassAndId(string $class, string $id): self
    {
        return new UnableToDeleteResourceException(sprintf('Resource of type [%s] with ID [%s] cannot be deleted because a client may have at least one [%s]', $class, $id, $class));
    }
}
