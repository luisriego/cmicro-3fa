<?php

declare(strict_types=1);

namespace App\Exception;

use DomainException;

use function sprintf;

final class UnableToCreateResourceException extends DomainException
{
    public static function fromNamedConstructor(string $class): self
    {
        return new UnableToCreateResourceException(sprintf('Cannot be created resource of type [%s] ', $class));
    }

    public static function createFromClassAndId(string $class, string $id): self
    {
        return new UnableToCreateResourceException(sprintf('Resource of type [%s] with ID [%s] not found', $class, $id));
    }

    public static function createFromClassAndEmail(string $class, string $email): self
    {
        return new UnableToCreateResourceException(sprintf('Resource of type [%s] with Email [%s] not found', $class, $email));
    }

    public static function createFromClassAndName(string $class, string $name): self
    {
        return new UnableToCreateResourceException(sprintf('Resource of type [%s] with Name [%s] not found', $class, $name));
    }
}
