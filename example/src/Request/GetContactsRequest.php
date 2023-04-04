<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class GetContactsRequest
{
    public function __construct(
        #[Assert\Length(min: 2)]
        public readonly ?string $search = null
    ) {
    }
}
