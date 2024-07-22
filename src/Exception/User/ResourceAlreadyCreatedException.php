<?php

declare(strict_types=1);

namespace App\Exception\User;

use DomainException;

use function sprintf;

final class ResourceAlreadyCreatedException extends DomainException
{
    public static function fromClassAndName(string $class, string $name): self
    {
        return new ResourceAlreadyCreatedException(sprintf('Resource of type [%s] with Name [%s] already exists', $class, $name));
    }
}
