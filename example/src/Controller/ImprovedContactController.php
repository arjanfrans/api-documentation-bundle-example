<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Request\GetContactsRequest;
use App\Request\UpdateContactRequest;
use App\Response\ContactResponse;
use Fusonic\ApiDocumentationBundle\Attribute\DocumentedRoute;
use Fusonic\HttpKernelExtensions\Attribute\FromRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Example controller using the DocumentedRoute.
 */
#[Route('/contacts-improved')]
final class ImprovedContactController extends AbstractController
{
    public function __construct(private readonly ContactRepository $contactRepository)
    {
    }

    /**
     * @return ContactResponse[]
     */
    #[DocumentedRoute('/', methods: 'GET')]
    public function getAllContactsAction(#[FromRequest] GetContactsRequest $request): array
    {
        $contacts = null === $request->search ? $this->contactRepository->findAll() : $this->contactRepository->search($request->search);

        return array_map(static fn (Contact $contact) => new ContactResponse($contact), $contacts);
    }

    #[DocumentedRoute('/{id}', methods: 'PATCH')]
    public function updateContactAction(#[FromRequest] UpdateContactRequest $request): ContactResponse
    {
        $contact = $this->contactRepository->find($request->id);

        if (null === $contact) {
            throw new NotFoundHttpException(sprintf('Contact with `id=%s` not found.', $request->id));
        }

        $contact->setFirstName($request->firstName);
        $contact->setLastName($request->lastName);

        return new ContactResponse($contact);
    }
}
