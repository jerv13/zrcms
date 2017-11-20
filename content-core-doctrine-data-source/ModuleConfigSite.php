<?php

namespace Zrcms\ContentCoreDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Action\UnpublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourcesBy;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersionsBy;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCoreDoctrineDataSource as This;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigSite
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
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
                    UpsertSiteCmsResource::class => [
                        'class' => This\Site\Api\CmsResource\UpsertSiteCmsResource::class,
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
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\ContentCoreDoctrineDataSource\Site' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Site/Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\ContentCoreDoctrineDataSource\Site'
                            => 'Zrcms\ContentCoreDoctrineDataSource\Site'
                        ]
                    ]
                ],
            ],
        ];
    }
}
