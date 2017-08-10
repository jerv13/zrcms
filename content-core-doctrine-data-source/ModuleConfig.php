<?php

namespace Zrcms\ContentCoreDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Action\UnpublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBy;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersion;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersionsBy;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
use Zrcms\ContentCore\Layout\Api\Action\PublishLayoutCmsResource;
use Zrcms\ContentCore\Layout\Api\Action\UnpublishLayoutCmsResource;
use Zrcms\ContentCore\Page\Api\Action\PublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Action\UnpublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourcesBy;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersion;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersionsBy;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Action\UnpublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourcesBy;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersionsBy;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourcesBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersionsBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\InsertLayoutVersion;
use Zrcms\ContentCoreDoctrineDataSource as This;

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

                    /**
                     * Block ===========================================
                     */

                    /**
                     * Container ===========================================
                     */
                    PublishContainerCmsResource::class => [
                        'class' => This\Container\Api\Action\PublishContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UnpublishContainerCmsResource::class => [
                        'class' => This\Container\Api\Action\UnpublishContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResource::class => [
                        'class' => This\Container\Api\Repository\FindContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResourcesBy::class => [
                        'class' => This\Container\Api\Repository\FindContainerCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResourcesBySitePaths::class => [
                        'class' => This\Container\Api\Repository\FindContainerCmsResourcesBySitePaths::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerVersion::class => [
                        'class' => This\Container\Api\Repository\FindContainerVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerVersionsBy::class => [
                        'class' => This\Container\Api\Repository\FindContainerVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertContainerVersion::class => [
                        'class' => This\Container\Api\Repository\InsertContainerVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],

                    /**
                     * Page ===========================================
                     */
                    PublishPageContainerCmsResource::class => [
                        'class' => This\Page\Api\Action\PublishPageContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UnpublishPageContainerCmsResource::class => [
                        'class' => This\Page\Api\Action\UnPublishPageContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageContainerCmsResource::class => [
                        'class' => This\Page\Api\Repository\FindPageContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageContainerCmsResourceBySitePath::class => [
                        'class' => This\Page\Api\Repository\FindPageContainerCmsResourceBySitePath::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageContainerCmsResourcesBy::class => [
                        'class' => This\Page\Api\Repository\FindPageContainerCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageContainerVersion::class => [
                        'class' => This\Page\Api\Repository\FindPageContainerVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageContainerVersionsBy::class => [
                        'class' => This\Page\Api\Repository\FindPageContainerVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertPageContainerVersion::class => [
                        'class' => This\Page\Api\Repository\InsertPageContainerVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],

                    /**
                     * Site ===========================================
                     */
                    PublishSiteCmsResource::class => [
                        'class' => This\Site\Api\Action\PublishSiteCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UnpublishSiteCmsResource::class => [
                        'class' => This\Site\Api\Action\UnpublishSiteCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindSiteCmsResource::class => [
                        'class' => This\Site\Api\Repository\FindSiteCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindSiteCmsResourceByHost::class => [
                        'class' => This\Site\Api\Repository\FindSiteCmsResourceByHost::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindSiteCmsResourcesBy::class => [
                        'class' => This\Site\Api\Repository\FindSiteCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindSiteVersion::class => [
                        'class' => This\Site\Api\Repository\FindSiteVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindSiteVersionsBy::class => [
                        'class' => This\Site\Api\Repository\FindSiteVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertSiteVersion::class => [
                        'class' => This\Site\Api\Repository\InsertSiteVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    /**
                     * Theme ===========================================
                     */
                    PublishLayoutCmsResource::class => [
                        'class' => This\Theme\Api\Action\PublishLayoutCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UnpublishLayoutCmsResource::class => [
                        'class' => This\Theme\Api\Action\UnpublishLayoutCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutCmsResource::class => [
                        'class' => This\Theme\Api\Repository\FindLayoutCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutCmsResourceByThemeNameLayoutName::class => [
                        'class' => This\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                            '1-' => FindThemeComponent::class, // @todo TEMP HACK
                        ],
                    ],
                    FindLayoutCmsResourcesBy::class => [
                        'class' => This\Theme\Api\Repository\FindLayoutCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutVersion::class => [
                        'class' => This\Theme\Api\Repository\FindLayoutVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                            '1-' => FindThemeComponent::class, // @todo TEMP HACK
                        ],
                    ],
                    FindLayoutVersionsBy::class => [
                        'class' => This\Theme\Api\Repository\FindLayoutVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertLayoutVersion::class => [
                        'class' => This\Theme\Api\Repository\InsertLayoutVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\ContentCoreDoctrineDataSource' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Container/Entity',
                            __DIR__ . '/Page/Entity',
                            __DIR__ . '/Site/Entity',
                            __DIR__ . '/Theme/Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\ContentCoreDoctrineDataSource' => 'Zrcms\ContentCoreDoctrineDataSource'
                        ]
                    ]
                ],
            ],
        ];
    }
}
