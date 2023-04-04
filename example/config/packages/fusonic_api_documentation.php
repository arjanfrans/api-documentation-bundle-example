<?php

declare(strict_types=1);

use Fusonic\HttpKernelExtensions\Attribute\FromRequest;
use Symfony\Config\FusonicApiDocumentationConfig;

return static function (FusonicApiDocumentationConfig $fusonicApiDocumentationConfig): void {
    $fusonicApiDocumentationConfig->requestObjectClass(FromRequest::class);
};
