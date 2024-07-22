<?php

declare(strict_types=1);

namespace App\Validation\Traits;

use App\Exception\InvalidArgumentException;
use function filter_var;
use function sprintf;

use const FILTER_VALIDATE_EMAIL;

trait AssertEmailTrait
{
    public function assertEmail(string $value): void
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw InvalidArgumentException::createFromMessage(sprintf('The e-mail address <%s> is considered invalid.', $value));
        }
    }
}
