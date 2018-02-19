<?php

namespace Zrcms\CoreSiteDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Reliv\CacheRat\Service\CacheArray;
use Zrcms\CoreSite\Api\ChangeLog\GetSiteChangeLogByDateRange;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesBy;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesPublished;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
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
                    GetSiteChangeLogByDateRange::class => [
                        'class' => \Zrcms\CoreSiteDoctrine\Api\ChangeLog\GetSiteChangeLogByDateRangeAbstract::class,
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
                            CacheArray::class, // @todo This can use the default cache now: Cache::class
                            ['literal' => \Zrcms\CoreSiteDoctrine\Api\CmsResource\FindSiteCmsResourceByHost::CACHE_KEY],
                            ['literal' => \Zrcms\CoreSiteDoctrine\Api\CmsResource\FindSiteCmsResourceByHost::CACHE_TTL],
                        ],
                    ],
                    FindSiteCmsResourcesBy::class => [
                        'class' => \Zrcms\CoreSiteDoctrine\Api\CmsResource\FindSiteCmsResourcesBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindSiteCmsResourcesPublished::class => [
                        'class' => \Zrcms\CoreSiteDoctrine\Api\CmsResource\FindSiteCmsResourcesPublished::class,
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
                            __DIR__ . '/Entity',
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
