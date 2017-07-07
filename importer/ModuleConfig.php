<?php

namespace Zrcms\Importer;

use Zrcms\Core\Container\Api\CreateContainerPublished;
use Zrcms\Core\Page\Api\CreatePagePublished;
use Zrcms\Core\Site\Api\CreateSitePublished;
use Zrcms\Importer\Api\Import;
use Zrcms\Importer\Middleware\ImportController;

/**
 * @author James Jervis - https://github.com/jerv13
 */
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
                            CreateContainerPublished::class
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
