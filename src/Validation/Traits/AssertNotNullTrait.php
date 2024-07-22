<?php

declare(strict_types=1);

namespace App\Validation\Traits;

use App\Exception\InvalidArgumentException;

use function array_combine;

trait AssertNotNullTrait
{
    public function assertNotNull(array $args, array $values): void
    {
        $args = array_combine($args, $values);

        $emptyValues = [];

        foreach ($args as $key => $value) {
            if (empty($value)) {
                $emptyValues[] = $key;
            }
        }

        if (!empty($emptyValues)) {
            throw InvalidArgumentException::createFromArray($emptyValues);
        }
    }
}
