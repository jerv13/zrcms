<?php

namespace Zrcms\Importer;

use Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
use Zrcms\ContentCore\Page\Api\Action\PublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\Importer\Api\Import;
use Zrcms\Importer\Api\ImportFactory;
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
                        'factory' => [
                            ImportFactory::class
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
