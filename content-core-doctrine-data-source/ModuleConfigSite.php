<?php

namespace Zrcms\ContentCoreDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentCore\Site\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\ContentCore\Site\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResource;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResourcesBy;
use Zrcms\ContentCore\Site\Api\Content\FindSiteVersion;
use Zrcms\ContentCore\Site\Api\Content\FindSiteVersionsBy;
use Zrcms\ContentCore\Site\Api\Content\InsertSiteVersion;
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
                    GetChangeLogByDateRange::class => [
                        'class' => This\Site\Api\ChangeLog\GetChangeLogByDateRange::class,
                        'arguments' => [EntityManager::class]
                    ],
                    UpsertSiteCmsResource::class => [
                        'class' => This\Site\Api\CmsResource\UpsertSiteCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindSiteCmsResource::class => [
                        'class' => This\Site\Api\CmsResource\FindSiteCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindSiteCmsResourceByHost::class => [
                        'class' => This\Site\Api\CmsResource\FindSiteCmsResourceByHost::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindSiteCmsResourcesBy::class => [
                        'class' => This\Site\Api\CmsResource\FindSiteCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindSiteVersion::class => [
                        'class' => This\Site\Api\Content\FindSiteVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindSiteVersionsBy::class => [
                        'class' => This\Site\Api\Content\FindSiteVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertSiteVersion::class => [
                        'class' => This\Site\Api\Content\InsertSiteVersion::class,
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
