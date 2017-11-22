<?php

namespace Zrcms\ContentCoreDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentCore\Layout\Api\CmsResource\UpsertLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResourcesBy;
use Zrcms\ContentCore\Theme\Api\Content\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Content\FindLayoutVersionsBy;
use Zrcms\ContentCore\Theme\Api\Component\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Content\InsertLayoutVersion;
use Zrcms\ContentCoreDoctrineDataSource as This;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigTheme
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    GetChangeLogByDateRange::class => [
                        'class' => This\Theme\Api\ChangeLog\GetChangeLogByDateRange::class,
                        'arguments' => [EntityManager::class]
                    ],
                    UpsertLayoutCmsResource::class => [
                        'class' => This\Theme\Api\CmsResource\UpsertLayoutCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutCmsResource::class => [
                        'class' => This\Theme\Api\CmsResource\FindLayoutCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutCmsResourceByThemeNameLayoutName::class => [
                        'class' => This\Theme\Api\CmsResource\FindLayoutCmsResourceByThemeNameLayoutName::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                            '1-' => This\Theme\Api\FallbackToComponentLayoutCmsResource::class, // @todo TEMP HACK
                        ],
                    ],
                    FindLayoutCmsResourcesBy::class => [
                        'class' => This\Theme\Api\CmsResource\FindLayoutCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutVersion::class => [
                        'class' => This\Theme\Api\Content\FindLayoutVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                            '1-' => This\Theme\Api\FallbackToComponentLayoutVersion::class, // @todo TEMP HACK
                        ],
                    ],
                    FindLayoutVersionsBy::class => [
                        'class' => This\Theme\Api\Content\FindLayoutVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertLayoutVersion::class => [
                        'class' => This\Theme\Api\Content\InsertLayoutVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    This\Theme\Api\FallbackToComponentLayoutCmsResource::class => [
                        'arguments' => [
                            '0-' => FindThemeComponent::class,
                            '1-' => This\Theme\Api\LayoutVersionFromComponent::class,
                        ],
                    ],
                    This\Theme\Api\FallbackToComponentLayoutVersion::class => [
                        'arguments' => [
                            '0-' => FindThemeComponent::class,
                            '1-' => This\Theme\Api\LayoutVersionFromComponent::class,
                        ],
                    ],
                    This\Theme\Api\LayoutVersionFromComponent::class => [],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\ContentCoreDoctrineDataSource\Theme' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Theme/Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\ContentCoreDoctrineDataSource\Theme'
                            => 'Zrcms\ContentCoreDoctrineDataSource\Theme'
                        ]
                    ]
                ],
            ],
        ];
    }
}
