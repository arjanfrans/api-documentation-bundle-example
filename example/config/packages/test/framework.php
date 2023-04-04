<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config) {
    $config
        ->test(true);

    $config
        ->session()
            ->storageFactoryId('session.storage.factory.mock_file');
};
