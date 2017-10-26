<?php

namespace Zrcms\ContentCoreDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentCore\Layout\Api\Action\PublishLayoutCmsResource;
use Zrcms\ContentCore\Layout\Api\Action\UnpublishLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourcesBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersionsBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\InsertLayoutVersion;
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
                    PublishLayoutCmsResource::class => [
                        'class' => This\Theme\Api\Action\PublishLayoutCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UnpublishLayoutCmsResource::class => [
                        'class' => This\Theme\Api\Action\UnpublishLayoutCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutCmsResource::class => [
                        'class' => This\Theme\Api\Repository\FindLayoutCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutCmsResourceByThemeNameLayoutName::class => [
                        'class' => This\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                            '1-' => This\Theme\Api\FallbackToComponentLayoutCmsResource::class, // @todo TEMP HACK
                        ],
                    ],
                    FindLayoutCmsResourcesBy::class => [
                        'class' => This\Theme\Api\Repository\FindLayoutCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindLayoutVersion::class => [
                        'class' => This\Theme\Api\Repository\FindLayoutVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                            '1-' => This\Theme\Api\FallbackToComponentLayoutVersion::class, // @todo TEMP HACK
                        ],
                    ],
                    FindLayoutVersionsBy::class => [
                        'class' => This\Theme\Api\Repository\FindLayoutVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertLayoutVersion::class => [
                        'class' => This\Theme\Api\Repository\InsertLayoutVersion::class,
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
