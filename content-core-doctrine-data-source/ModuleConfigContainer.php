<?php

namespace Zrcms\ContentCoreDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentCore\Container\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\ContentCore\Container\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\ContentCore\Container\Api\CmsResource\FindContainerCmsResource;
use Zrcms\ContentCore\Container\Api\CmsResource\FindContainerCmsResourcesBy;
use Zrcms\ContentCore\Container\Api\CmsResource\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Api\Content\FindContainerVersion;
use Zrcms\ContentCore\Container\Api\Content\FindContainerVersionsBy;
use Zrcms\ContentCore\Container\Api\Content\InsertContainerVersion;
use Zrcms\ContentCoreDoctrineDataSource as This;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigContainer
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    GetChangeLogByDateRange::class => [
                        'class' => This\Container\Api\ChangeLog\GetChangeLogByDateRange::class,
                        'arguments' => [EntityManager::class]
                    ],
                    UpsertContainerCmsResource::class => [
                        'class' => This\Container\Api\CmsResource\UpsertContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UpsertContainerCmsResource::class => [
                        'class' => This\Container\Api\CmsResource\UpsertContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResource::class => [
                        'class' => This\Container\Api\CmsResource\FindContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResourcesBy::class => [
                        'class' => This\Container\Api\CmsResource\FindContainerCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResourcesBySitePaths::class => [
                        'class' => This\Container\Api\CmsResource\FindContainerCmsResourcesBySitePaths::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerVersion::class => [
                        'class' => This\Container\Api\Content\FindContainerVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerVersionsBy::class => [
                        'class' => This\Container\Api\Content\FindContainerVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertContainerVersion::class => [
                        'class' => This\Container\Api\Content\InsertContainerVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\ContentCoreDoctrineDataSource\Container' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Container/Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\ContentCoreDoctrineDataSource\Container'
                            => 'Zrcms\ContentCoreDoctrineDataSource\Container'
                        ]
                    ]
                ],
            ],
        ];
    }
}
