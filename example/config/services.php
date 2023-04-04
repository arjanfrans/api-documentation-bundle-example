<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Fusonic\HttpKernelExtensions\Controller\RequestDtoResolver;
use Fusonic\HttpKernelExtensions\Normalizer\ConstraintViolationExceptionNormalizer;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure();

    $services->load('App\\', '../src/*')
        ->exclude([
            '../src/Entity/',
            '../src/Response/',
            '../src/Fixtures/',
            '../src/Request/',
            '../src/Kernel.php',
    ]);

    $services->set(RequestDtoResolver::class)
        ->tag('controller.argument_value_resolver', [
            'priority' => 50,
        ]);

    $services->set(ConstraintViolationExceptionNormalizer::class)
        ->arg('$normalizer', service('serializer.normalizer.constraint_violation_list'));
};
