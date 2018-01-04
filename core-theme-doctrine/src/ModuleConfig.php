<?php

namespace Zrcms\CoreThemeDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreTheme\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResource;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourcesBy;
use Zrcms\CoreTheme\Api\CmsResource\UpsertLayoutCmsResource;
use Zrcms\CoreTheme\Api\Content\FindLayoutVersion;
use Zrcms\CoreTheme\Api\Content\FindLayoutVersionsBy;
use Zrcms\CoreTheme\Api\Content\InsertLayoutVersion;

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
                        'class' => \Zrcms\CoreThemeDoctrine\Api\ChangeLog\GetChangeLogByDateRangeAbstract::class,
                        'arguments' => [EntityManager::class]
                    ],
                    UpsertLayoutCmsResource::class => [
                        'class' => \Zrcms\CoreThemeDoctrine\Api\CmsResource\UpsertLayoutCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindLayoutCmsResource::class => [
                        'class' => \Zrcms\CoreThemeDoctrine\Api\CmsResource\FindLayoutCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindLayoutCmsResourceByThemeNameLayoutName::class => [
                        'class'
                        => \Zrcms\CoreThemeDoctrine\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName::class,
                        'arguments' => [
                            EntityManager::class,
                            // @todo TEMP HACK
                            \Zrcms\CoreThemeDoctrine\Api\FallbackToComponentLayoutCmsResource::class,
                        ],
                    ],
                    FindLayoutCmsResourcesBy::class => [
                        'class' => \Zrcms\CoreThemeDoctrine\Api\CmsResource\FindLayoutCmsResourcesBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindLayoutVersion::class => [
                        'class' => \Zrcms\CoreThemeDoctrine\Api\Content\FindLayoutVersion::class,
                        'arguments' => [
                            EntityManager::class,
                            // @todo TEMP HACK
                            \Zrcms\CoreThemeDoctrine\Api\FallbackToComponentLayoutVersion::class,
                        ],
                    ],
                    FindLayoutVersionsBy::class => [
                        'class' => \Zrcms\CoreThemeDoctrine\Api\Content\FindLayoutVersionsBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    InsertLayoutVersion::class => [
                        'class' => \Zrcms\CoreThemeDoctrine\Api\Content\InsertLayoutVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    \Zrcms\CoreThemeDoctrine\Api\FallbackToComponentLayoutCmsResource::class => [
                        'arguments' => [
                            FindComponent::class,
                            \Zrcms\CoreThemeDoctrine\Api\LayoutVersionFromComponent::class,
                        ],
                    ],
                    \Zrcms\CoreThemeDoctrine\Api\FallbackToComponentLayoutVersion::class => [
                        'arguments' => [
                            FindComponent::class,
                            \Zrcms\CoreThemeDoctrine\Api\LayoutVersionFromComponent::class,
                        ],
                    ],
                    \Zrcms\CoreThemeDoctrine\Api\LayoutVersionFromComponent::class => [],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\CoreThemeDoctrine' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\CoreThemeDoctrine'
                            => 'Zrcms\CoreThemeDoctrine'
                        ]
                    ]
                ],
            ],
        ];
    }
}
