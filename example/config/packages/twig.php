<?php

declare(strict_types=1);

use Symfony\Config\TwigConfig;

return static function (TwigConfig $config) {
    $config
        ->defaultPath('%kernel.project_dir%/templates')
        ->strictVariables(true);
};
