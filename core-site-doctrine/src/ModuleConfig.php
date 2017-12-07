<?php

namespace Zrcms\CoreSiteDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\CoreSite\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesBy;
use Zrcms\CoreSite\Api\Content\FindSiteVersion;
use Zrcms\CoreSite\Api\Content\FindSiteVersionsBy;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;

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
                        'class' => \Zrcms\CoreSiteDoctrine\Api\ChangeLog\GetChangeLogByDateRange::class,
                        'arguments' => [EntityManager::class]
                    ],
                    UpsertSiteCmsResource::class => [
                        'class' => \Zrcms\CoreSiteDoctrine\Api\CmsResource\UpsertSiteCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindSiteCmsResource::class => [
                        'class' => \Zrcms\CoreSiteDoctrine\Api\CmsResource\FindSiteCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindSiteCmsResourceByHost::class => [
                        'class' => \Zrcms\CoreSiteDoctrine\Api\CmsResource\FindSiteCmsResourceByHost::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindSiteCmsResourcesBy::class => [
                        'class' => \Zrcms\CoreSiteDoctrine\Api\CmsResource\FindSiteCmsResourcesBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindSiteVersion::class => [
                        'class' => \Zrcms\CoreSiteDoctrine\Api\Content\FindSiteVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindSiteVersionsBy::class => [
                        'class' => \Zrcms\CoreSiteDoctrine\Api\Content\FindSiteVersionsBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    InsertSiteVersion::class => [
                        'class' => \Zrcms\CoreSiteDoctrine\Api\Content\InsertSiteVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\CoreSiteDoctrine' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Site/Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\CoreSiteDoctrine'
                            => 'Zrcms\CoreSiteDoctrine'
                        ]
                    ]
                ],
            ],
        ];
    }
}
