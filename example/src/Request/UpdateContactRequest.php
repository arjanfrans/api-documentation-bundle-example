<?php

declare(strict_types=1);

namespace App\Request;

final class UpdateContactRequest
{
    public function __construct(
        public readonly int $id,
        public readonly string $firstName,
        public readonly string $lastName
    ) {
    }
}
