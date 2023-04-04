<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contact;
use App\Fixtures\ContactFixtures;

final class ContactRepository
{
    /**
     * @var Contact[]
     */
    private readonly array $contacts;

    public function __construct()
    {
        $this->contacts = ContactFixtures::fixtures();
    }

    /**
     * @return Contact[]
     */
    public function findAll(): array
    {
        return $this->contacts;
    }

    /**
     * @return Contact[]
     */
    public function search(string $search): array
    {
        return array_values(
            array_filter(
                $this->contacts, static fn (Contact $contact) => str_contains($contact->getName(),
                    $search
                )
            )
        );
    }

    public function find(int $id): ?Contact
    {
        foreach ($this->contacts as $contact) {
            if ($contact->getId() === $id) {
                return $contact;
            }
        }

        return null;
    }
}
