<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ViewEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly NormalizerInterface $normalizer)
    {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $view = $event->getControllerResult();

        if (null === $view) {
            $response = new JsonResponse('', Response::HTTP_NO_CONTENT);
        } else {
            $response = new JsonResponse($this->normalizer->normalize($view));
        }

        $event->setResponse($response);
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['onKernelView'],
        ];
    }
}
