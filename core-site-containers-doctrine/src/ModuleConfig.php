<?php

namespace Zrcms\CoreSiteContainerDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\CoreSiteContainer\Api\ChangeLog\GetSiteContainerChangeLogByDateRange;
use Zrcms\CoreSiteContainer\Api\CmsResource\CreateSiteContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBy;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBySiteNames;
use Zrcms\CoreSiteContainer\Api\CmsResource\UpdateSiteContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\Content\FindSiteContainerVersion;
use Zrcms\CoreSiteContainer\Api\Content\FindSiteContainerVersionsBy;
use Zrcms\CoreSiteContainer\Api\Content\InsertSiteContainerVersion;
use Zrcms\CoreSiteContainerDoctrine\Api as ThisApi;

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
                    GetSiteContainerChangeLogByDateRange::class => [
                        'class' => ThisApi\ChangeLog\GetSiteContainerChangeLogByDateRangeAbstract::class,
                        'arguments' => [EntityManager::class]
                    ],

                    CreateSiteContainerCmsResource::class => [
                        'class' => ThisApi\CmsResource\CreateSiteContainerCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindSiteContainerCmsResource::class => [
                        'class' => ThisApi\CmsResource\FindSiteContainerCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindSiteContainerCmsResourcesBy::class => [
                        'class' => ThisApi\CmsResource\FindSiteContainerCmsResourcesBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindSiteContainerCmsResourcesBySiteNames::class => [
                        'class' => ThisApi\CmsResource\FindSiteContainerCmsResourcesBySiteNames::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    UpdateSiteContainerCmsResource::class => [
                        'class' => ThisApi\CmsResource\UpdateSiteContainerCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],

                    FindSiteContainerVersion::class => [
                        'class' => ThisApi\Content\FindSiteContainerVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindSiteContainerVersionsBy::class => [
                        'class' => ThisApi\Content\FindSiteContainerVersionsBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    InsertSiteContainerVersion::class => [
                        'class' => ThisApi\Content\InsertSiteContainerVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\CoreSiteContainerDoctrine' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\CoreSiteContainerDoctrine'
                            => 'Zrcms\CoreSiteContainerDoctrine'
                        ]
                    ]
                ],
            ],
        ];
    }
}
