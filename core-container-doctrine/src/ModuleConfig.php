<?php

namespace Zrcms\CoreContainerDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\CoreContainer\Api\ChangeLog\GetContainerChangeLogByDateRange;
use Zrcms\CoreContainer\Api\CmsResource\CreateContainerCmsResource;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResource;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBy;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBySiteNames;
use Zrcms\CoreContainer\Api\CmsResource\UpsertContainerCmsResource;
use Zrcms\CoreContainer\Api\Content\FindContainerVersion;
use Zrcms\CoreContainer\Api\Content\FindContainerVersionsBy;
use Zrcms\CoreContainer\Api\Content\InsertContainerVersion;

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
                    GetContainerChangeLogByDateRange::class => [
                        'class' => \Zrcms\CoreContainerDoctrine\Api\ChangeLog\GetContainerChangeLogByDateRangeAbstract::class,
                        'arguments' => [EntityManager::class]
                    ],

                    CreateContainerCmsResource::class => [
                        'class' => \Zrcms\CoreContainerDoctrine\Api\CmsResource\CreateContainerCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResource::class => [
                        'class' => \Zrcms\CoreContainerDoctrine\Api\CmsResource\FindContainerCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResourcesBy::class => [
                        'class' => \Zrcms\CoreContainerDoctrine\Api\CmsResource\FindContainerCmsResourcesBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindContainerCmsResourcesBySiteNames::class => [
                        'class'
                        => \Zrcms\CoreContainerDoctrine\Api\CmsResource\FindContainerCmsResourcesBySiteNames::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    UpsertContainerCmsResource::class => [
                        'class' => \Zrcms\CoreContainerDoctrine\Api\CmsResource\UpsertContainerCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],

                    FindContainerVersion::class => [
                        'class' => \Zrcms\CoreContainerDoctrine\Api\Content\FindContainerVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindContainerVersionsBy::class => [
                        'class' => \Zrcms\CoreContainerDoctrine\Api\Content\FindContainerVersionsBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    InsertContainerVersion::class => [
                        'class' => \Zrcms\CoreContainerDoctrine\Api\Content\InsertContainerVersion::class,
                        'arguments' => [
                            EntityManager::class,
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
                            __DIR__ . '/Entity',
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
