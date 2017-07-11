<?php

namespace Zrcms\Importer;

use Zrcms\Core\Container\Api\CreateContainerPublished;
use Zrcms\Core\Page\Api\CreatePagePublished;
use Zrcms\Core\Site\Api\CreateSitePublished;
use Zrcms\Core\Uri\Api\BuildCmsUri;
use Zrcms\Core\Uri\Api\ParseCmsUri;
use Zrcms\Importer\Api\Import;
use Zrcms\Importer\Middleware\ImportController;

class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    Import::class => [
                        'arguments' => [
                            CreateSitePublished::class,
                            CreatePagePublished::class,
                            CreateContainerPublished::class,
                            BuildCmsUri::class,
                            ParseCmsUri::class
                        ]
                    ],
                    ImportController::class => [
                        'arguments' => [
                            Import::class
                        ]
                    ]
                ]
            ]
        ];
    }
}