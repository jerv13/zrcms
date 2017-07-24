<?php

namespace Zrcms\Importer;

use Zrcms\ContentCore\Container\Api\CreateContainerPublished;
use Zrcms\ContentCore\Page\Api\CreatePagePublished;
use Zrcms\ContentCore\Site\Api\CreateSitePublished;
use Zrcms\ContentCore\Uri\Api\BuildCmsUri;
use Zrcms\ContentCore\Uri\Api\ParseCmsUri;
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
