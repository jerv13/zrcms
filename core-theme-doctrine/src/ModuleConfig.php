<?php

namespace Zrcms\CoreThemeDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreTheme\Api\CmsResource\UpsertLayoutCmsResource;
use Zrcms\CoreTheme\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResource;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourcesBy;
use Zrcms\CoreTheme\Api\Content\FindLayoutVersion;
use Zrcms\CoreTheme\Api\Content\FindLayoutVersionsBy;
use Zrcms\CoreTheme\Api\Content\InsertLayoutVersion;
use Zrcms\CoreThemeDoctrine as This;

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
                    UpsertLayoutCmsResource::class => [
                        'class' => This\Api\CmsResource\UpsertLayoutCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutCmsResource::class => [
                        'class' => This\Api\CmsResource\FindLayoutCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutCmsResourceByThemeNameLayoutName::class => [
                        'class' => This\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                            '1-' => This\Api\FallbackToComponentLayoutCmsResource::class, // @todo TEMP HACK
                        ],
                    ],
                    FindLayoutCmsResourcesBy::class => [
                        'class' => This\Api\CmsResource\FindLayoutCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutVersion::class => [
                        'class' => This\Api\Content\FindLayoutVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                            '1-' => This\Api\FallbackToComponentLayoutVersion::class, // @todo TEMP HACK
                        ],
                    ],
                    FindLayoutVersionsBy::class => [
                        'class' => This\Api\Content\FindLayoutVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertLayoutVersion::class => [
                        'class' => This\Api\Content\InsertLayoutVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    This\Api\FallbackToComponentLayoutCmsResource::class => [
                        'arguments' => [
                            '0-' => FindComponent::class,
                            '1-' => This\Api\LayoutVersionFromComponent::class,
                        ],
                    ],
                    This\Api\FallbackToComponentLayoutVersion::class => [
                        'arguments' => [
                            '0-' => FindComponent::class,
                            '1-' => This\Api\LayoutVersionFromComponent::class,
                        ],
                    ],
                    This\Api\LayoutVersionFromComponent::class => [],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\CoreThemeDoctrine' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Theme/Entity',
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
