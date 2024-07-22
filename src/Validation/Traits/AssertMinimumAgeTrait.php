<?php

declare(strict_types=1);

namespace App\Validation\Traits;

use App\Exception\InvalidArgumentException;

use function sprintf;

trait AssertMinimumAgeTrait
{
    public function assertMinimumAge(int $age, int $minimumAge): void
    {
        if ($minimumAge > $age) {
            throw InvalidArgumentException::createFromMessage(sprintf('Age has to be at least %d', $minimumAge));
        }
    }
}
