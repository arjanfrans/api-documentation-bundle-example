<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ViewResponseListener implements EventSubscriberInterface
{
    public function __construct(private readonly NormalizerInterface $normalizer, public readonly bool $autoCacheControl = false)
    {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $view = $event->getControllerResult();

        if (null === $view) {
            $response = new JsonResponse('', 204);
        } else {
            $data = $this->normalizer->normalize(
                $view,
                null,
                [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]
            );

            $response = new JsonResponse($data);
        }

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['onKernelView', 30],
        ];
    }
}
