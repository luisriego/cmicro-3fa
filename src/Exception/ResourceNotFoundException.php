<?php

declare(strict_types=1);

namespace App\Exception;

use DomainException;

use function sprintf;

final class ResourceNotFoundException extends DomainException
{
    public static function createFromClassAndId(string $class, string $id): self
    {
        return new ResourceNotFoundException(sprintf('Resource of type [%s] with ID [%s] not found', $class, $id));
    }

    public static function createFromClassAndEmail(string $class, string $email): self
    {
        return new ResourceNotFoundException(sprintf('Resource of type [%s] with Email [%s] not found', $class, $email));
    }

    public static function createFromClassAndName(string $class, string $name): self
    {
        return new ResourceNotFoundException(sprintf('Resource of type [%s] with Name [%s] not found', $class, $name));
    }

    public static function createFromClassAndIntId(string $class, int $id): self
    {
        return new ResourceNotFoundException(sprintf('Resource of type [%s] with ID [%d] not found', $class, $id));
    }
}
