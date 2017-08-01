<?php

namespace Zrcms\Importer;

use Zrcms\Importer\Api\Import;
use Zrcms\Importer\Api\ImportFactory;
use Zrcms\Importer\Cli\Command\ImportCommand;
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
            'console' => [
                'commands' => [
                    ImportCommand::class => ImportCommand::class,
                ],
            ],

            'dependencies' => [
                'config_factories' => [
                    /**
                     * Api ===========================================
                     */
                    Import::class => [
                        'factory' => ImportFactory::class,
                    ],

                    /**
                     * Cli ===========================================
                     */
                    ImportCommand::class => [
                        'arguments' => [
                            Import::class
                        ]
                    ],

                    /**
                     * Middleware ===========================================
                     */
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
