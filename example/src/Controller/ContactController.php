<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Request\GetContactsRequest;
use App\Request\UpdateContactRequest;
use App\Response\ContactResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Bad example of a controller.
 *
 * @deprecated
 */
#[Route('/contacts')]
final class ContactController extends AbstractController
{
    public function __construct(
        private readonly ContactRepository $contactRepository,
        private readonly ValidatorInterface $validator,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    #[Route('/', methods: 'GET')]
    #[OA\Parameter(name: 'GetContactsRequest', in: 'query', content: new Model(
        type: GetContactsRequest::class
    ), explode: true)]
    #[OA\Response(
        response: 200,
        description: 'ContactResponse[]',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ContactResponse::class))
        )
    )]
    public function getAllContactsAction(Request $request): JsonResponse
    {
        $object = new GetContactsRequest($request->get('search'));
        $errors = $this->validator->validate($object);

        if ($errors->count() > 0) {
            throw new ValidationFailedException($object, $errors);
        }

        $contacts = null === $object->search ? $this->contactRepository->findAll() : $this->contactRepository->search(
            $object->search
        );

        return new JsonResponse(
            $this->normalizer->normalize(
                array_map(static fn (Contact $contact) => new ContactResponse($contact), $contacts)
            ), 200
        );
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
    public function updateContactAction(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        $object = new UpdateContactRequest(
            $body['id'],
            $body['firstName'],
            $body['lastName']
        );
        $errors = $this->validator->validate($object);

        if ($errors->count() > 0) {
            throw new ValidationFailedException($object, $errors);
        }

        $contact = $this->contactRepository->find($object->id);

        if (null === $contact) {
            throw new NotFoundHttpException(sprintf('Contact with `id=%s` not found.', $object->id));
        }

        $contact->setFirstName($object->firstName);
        $contact->setLastName($object->lastName);

        return new JsonResponse($this->normalizer->normalize(new ContactResponse($contact)), 200);
    }
}
