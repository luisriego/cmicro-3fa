<?php

declare(strict_types=1);

namespace App\Validation\Traits;

use App\Exception\InvalidArgumentException;

use function define;
use function sprintf;

trait AssertRatingValueTrait
{
    public function assertRatingValue(int $value): void
    {
        define('MAX_RATING_VALUE', 500);
        define('MIN_RATING_VALUE', 0);

        if ($value > MAX_RATING_VALUE) {
            throw InvalidArgumentException::createFromMessage(
                sprintf(
                    'The maximum value for the rating is %d, but received %d',
                    MAX_RATING_VALUE,
                    $value,
                ),
            );
        }

        if ($value < MIN_RATING_VALUE) {
            throw InvalidArgumentException::createFromMessage(
                sprintf(
                    'The minimum value for the rating is %d, but received %d',
                    MIN_RATING_VALUE,
                    $value,
                ),
            );
        }
    }
}
