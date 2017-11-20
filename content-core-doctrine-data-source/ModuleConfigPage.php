<?php

namespace Zrcms\ContentCoreDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageDraftCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\FindPageCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\FindPageCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageCmsResourcesBy;
use Zrcms\ContentCore\Page\Api\Repository\FindPageTemplateCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageTemplateCmsResourcesBy;
use Zrcms\ContentCore\Page\Api\Repository\FindPageVersion;
use Zrcms\ContentCore\Page\Api\Repository\FindPageVersionsBy;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageVersion;
use Zrcms\ContentCoreDoctrineDataSource as This;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigPage
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    UpsertPageCmsResource::class => [
                        'class' => This\Page\Api\CmsResource\UpsertPageCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UpsertPageTemplateCmsResource::class => [
                        'class' => This\Page\Api\CmsResource\UpsertPageTemplateCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UpsertPageDraftCmsResource::class => [
                        'class' => This\Page\Api\CmsResource\UpsertPageDraftCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageCmsResource::class => [
                        'class' => This\Page\Api\Repository\FindPageCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageCmsResourceBySitePath::class => [
                        'class' => This\Page\Api\Repository\FindPageCmsResourceBySitePath::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageCmsResourcesBy::class => [
                        'class' => This\Page\Api\Repository\FindPageCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageVersion::class => [
                        'class' => This\Page\Api\Repository\FindPageVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageVersionsBy::class => [
                        'class' => This\Page\Api\Repository\FindPageVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageTemplateCmsResourceBySitePath::class => [
                        'class' => This\Page\Api\Repository\FindPageTemplateCmsResourceBySitePath::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageTemplateCmsResourcesBy::class => [
                        'class' => This\Page\Api\Repository\FindPageTemplateCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertPageVersion::class => [
                        'class' => This\Page\Api\Repository\InsertPageVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\ContentCoreDoctrineDataSource\Page' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Page/Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\ContentCoreDoctrineDataSource\Page'
                            => 'Zrcms\ContentCoreDoctrineDataSource\Page'
                        ]
                    ]
                ],
            ],
        ];
    }
}
