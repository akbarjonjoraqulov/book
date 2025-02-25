<?php

declare(strict_types=1);

namespace App\Component\User;

use Symfony\Component\Serializer\Attribute\Groups;

class FullNameDto
{
    public function __construct(
        #[Groups(['user:read', 'user:write'])]
        public string $givenName,
        #[Groups(['user:write'])]
        public string $familyName,
        #[Groups(['user:read', 'user:write'])]
        public bool $isMarried,
    )
    {

    }

    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function isMarried(): bool
    {
        return $this->isMarried;
    }
}