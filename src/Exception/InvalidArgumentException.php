<?php

declare(strict_types=1);

namespace App\Exception;

use InvalidArgumentException as NativeInvalidArgumentException;

use function implode;
use function sprintf;

final class InvalidArgumentException extends NativeInvalidArgumentException
{
    public static function createFromMessage(string $message): self
    {
        return new InvalidArgumentException($message);
    }

    public static function createFromArgument(string $argument): self
    {
        return new InvalidArgumentException(sprintf('Invalid argument [%s]', $argument));
    }

    public static function createFromArray(array $arguments): self
    {
        return new InvalidArgumentException(sprintf('Invalid arguments [%s]', implode(', ', $arguments)));
    }

    public static function createFromMinAndMaxLength(int $min, int $max): self
    {
        return new InvalidArgumentException(sprintf('Value must be min [%d] and max [%d] characters', $min, $max));
    }
}
