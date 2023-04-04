<?php

declare(strict_types=1);

namespace App\Request;

final class GetOneContactRequest
{
    public function __construct(
        public readonly int $id
    ) {
    }
}
