<?php

declare(strict_types=1);

namespace App\Response;

use App\Entity\Contact;

final class ContactResponse
{
    public readonly int $id;
    public readonly string $name;

    public function __construct(Contact $contact)
    {
        $this->id = $contact->getId();
        $this->name = sprintf('%s %s', $contact->getFirstName(), $contact->getLastName());
    }
}
