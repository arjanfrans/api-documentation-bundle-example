<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Entity\Contact;

final class ContactFixtures
{
    /**
     * @return Contact[]
     */
    public static function fixtures(): array
    {
        return [
            new Contact(1, 'Juliet', 'O\' Hara'),
            new Contact(2, 'Burton', 'Guster'),
            new Contact(3, 'Henry', 'Spencer'),
            new Contact(4, 'Karen', 'Vick'),
            new Contact(5, 'Carlton', 'Lassiter'),
            new Contact(6, 'Shawn', 'Spencer'),
        ];
    }
}
