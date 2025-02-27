<?php

declare(strict_types=1);

namespace App\Component\User;

use Symfony\Component\Serializer\Attribute\Groups;

readonly class MaxAgeDto
{
    public function __construct(#[Groups('user:read')] private int $maxEge )
    {
    }

    public function getMaxEge(): int
    {
        return $this->maxEge;
    }
}
