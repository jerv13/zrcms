<?php

namespace Zrcms\CoreContainerDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\CoreContainer\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\CoreContainer\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResource;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBy;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBySitePaths;
use Zrcms\CoreContainer\Api\Content\FindContainerVersion;
use Zrcms\CoreContainer\Api\Content\FindContainerVersionsBy;
use Zrcms\CoreContainer\Api\Content\InsertContainerVersion;
use Zrcms\CoreContainer as This;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    GetChangeLogByDateRange::class => [
                        'class' => This\Api\ChangeLog\GetChangeLogByDateRange::class,
                        'arguments' => [EntityManager::class]
                    ],
                    UpsertContainerCmsResource::class => [
                        'class' => This\Api\CmsResource\UpsertContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UpsertContainerCmsResource::class => [
                        'class' => This\Api\CmsResource\UpsertContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResource::class => [
                        'class' => This\Api\CmsResource\FindContainerCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResourcesBy::class => [
                        'class' => This\Api\CmsResource\FindContainerCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResourcesBySitePaths::class => [
                        'class' => This\Api\CmsResource\FindContainerCmsResourcesBySitePaths::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerVersion::class => [
                        'class' => This\Api\Content\FindContainerVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindContainerVersionsBy::class => [
                        'class' => This\Api\Content\FindContainerVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertContainerVersion::class => [
                        'class' => This\Api\Content\InsertContainerVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\CoreContainerDoctrine' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Container/Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\CoreContainerDoctrine'
                            => 'Zrcms\CoreContainerDoctrine'
                        ]
                    ]
                ],
            ],
        ];
    }
}
