<?php

namespace Zrcms\Importer;

use Zrcms\Importer\Api\Import;
use Zrcms\Importer\Api\ImportFactory;
use Zrcms\Importer\Api\ImportUtilities;
use Zrcms\Importer\Api\ImportUtilitiesFactory;
use Zrcms\Importer\Api\ImportPage;
use Zrcms\Importer\Api\ImportPageFactory;
use Zrcms\Importer\Api\ImportPages;
use Zrcms\Importer\Api\ImportPagesFactory;
use Zrcms\Importer\Api\ImportPageTemplate;
use Zrcms\Importer\Api\ImportPageTemplateFactory;
use Zrcms\Importer\Api\ImportPageTemplates;
use Zrcms\Importer\Api\ImportPageTemplatesFactory;
use Zrcms\Importer\Api\ImportRedirect;
use Zrcms\Importer\Api\ImportRedirectFactory;
use Zrcms\Importer\Api\ImportRedirects;
use Zrcms\Importer\Api\ImportRedirectsFactory;
use Zrcms\Importer\Api\ImportSite;
use Zrcms\Importer\Api\ImportSiteContainer;
use Zrcms\Importer\Api\ImportSiteContainerFactory;
use Zrcms\Importer\Api\ImportSiteContainers;
use Zrcms\Importer\Api\ImportSiteContainersFactory;
use Zrcms\Importer\Api\ImportSiteFactory;
use Zrcms\Importer\Api\ImportSites;
use Zrcms\Importer\Api\ImportSitesFactory;
use Zrcms\Importer\Cli\Command\ImportCommand;
use Zrcms\Importer\Middleware\ImportController;

class ModuleConfig
{
    /**
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
                    ImportPage::class => [
                        'factory' => ImportPageFactory::class,
                    ],
                    ImportPages::class => [
                        'factory' => ImportPagesFactory::class,
                    ],
                    ImportPageTemplate::class => [
                        'factory' => ImportPageTemplateFactory::class,
                    ],
                    ImportPageTemplates::class => [
                        'factory' => ImportPageTemplatesFactory::class,
                    ],
                    ImportRedirect::class => [
                        'factory' => ImportRedirectFactory::class,
                    ],
                    ImportRedirects::class => [
                        'factory' => ImportRedirectsFactory::class,
                    ],
                    ImportSite::class => [
                        'factory' => ImportSiteFactory::class,
                    ],
                    ImportSites::class => [
                        'factory' => ImportSitesFactory::class,
                    ],
                    ImportSiteContainer::class => [
                        'factory' => ImportSiteContainerFactory::class,
                    ],
                    ImportSiteContainers::class => [
                        'factory' => ImportSiteContainersFactory::class,
                    ],
                    ImportUtilities::class => [
                        'factory' => ImportUtilitiesFactory::class,
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
