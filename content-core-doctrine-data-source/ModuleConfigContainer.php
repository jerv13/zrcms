<?php

namespace Zrcms\ContentCoreDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentCore\Container\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBy;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersion;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersionsBy;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
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
