<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config) {
    $config
        ->secret('%env(APP_SECRET)%')
        ->httpMethodOverride(false)
        ->handleAllThrowables(true);

    $config
        ->session()
            ->handlerId(null)
            ->cookieSamesite('auto')
            ->cookieSamesite('lax')
            ->storageFactoryId('session.storage.factory.native');

    $config
        ->phpErrors()
            ->log();
};
