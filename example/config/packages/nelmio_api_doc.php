<?php

declare(strict_types=1);

use Symfony\Config\NelmioApiDocConfig;

return static function (NelmioApiDocConfig $config): void {
    $config
        ->documentation('info', [
            'title' => 'Example API',
            'description' => 'Example API with Fusonic ApiDocumentationBundle',
            'version' => '1.0.0',
        ])
        ->areas('default', [
            'path_patterns' => ['^/api(?!/(docs|docs.json|_error)$)'],
        ]);
};
