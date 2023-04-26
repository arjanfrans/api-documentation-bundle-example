<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Request\GetContactsRequest;
use App\Request\GetOneContactRequest;
use App\Request\UpdateContactRequest;
use App\Response\ContactResponse;
use Fusonic\HttpKernelExtensions\Attribute\FromRequest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Example controller not using the DocumentedRoute.
 *
 * @deprecated
 */
#[Route('/contacts')]
final class ContactController extends AbstractController
{
    public function __construct(private readonly ContactRepository $contactRepository, private readonly ValidatorInterface $validator)
    {
    }

    /**
     * @return ContactResponse[]
     */
    #[Route('/', methods: 'GET')]
    #[OA\Parameter(name: 'GetContactsRequest', in: 'query', content: new Model(type: GetContactsRequest::class), explode: true)]
    #[OA\Response(
        response: 200,
        description: 'ContactResponse[]',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ContactResponse::class))
        )
    )]
    public function getAllContactsAction(Request $request): array
    {
        $object = new GetContactsRequest($request->get('search'));
        $errors = $this->validator->validate($object);
        
        if ($errors) {
            throw $errors;
        }
        
        $contacts = null === $object->search ? $this->contactRepository->findAll() : $this->contactRepository->search($object->search);

        return array_map(static fn (Contact $contact) => new ContactResponse($contact), $contacts);
    }

    #[Route('/{id}', methods: 'GET')]
    #[OA\Response(
        response: 200,
        description: 'ContactResponse',
        content: new Model(type: ContactResponse::class)
    )]
    public function getOneContactAction(#[FromRequest] GetOneContactRequest $request): ContactResponse
    {
        $contact = $this->contactRepository->find($request->id);

        if (null === $contact) {
            throw new NotFoundHttpException(sprintf('Contact with `id=%s` not found.', $request->id));
        }

        return new ContactResponse($contact);
    }

    #[Route('/{id}', methods: 'POST')]
    #[OA\RequestBody(
        required: true,
        content: new Model(type: UpdateContactRequest::class))]
    #[OA\Response(
        response: 200,
        description: 'ContactResponse',
        content: new Model(type: ContactResponse::class),
    )]
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
