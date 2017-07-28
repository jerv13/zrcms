<?php

namespace Zrcms\Importer;

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
