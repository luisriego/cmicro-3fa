<?php

declare(strict_types=1);

namespace App\Validation\Traits;

use App\Exception\InvalidArgumentException;

use function mb_strlen;

trait AssertLengthRangeTrait
{
    public function assertValueRangeLength(string $value, int $min, int $max): void
    {
        if (mb_strlen($value) < $min || mb_strlen($value) > $max) {
            throw InvalidArgumentException::createFromMinAndMaxLength($min, $max);
        }
    }
}
