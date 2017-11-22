<?php

namespace Zrcms\ContentCoreDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentCore\Page\Api\Action\PublishPageCmsResource;
use Zrcms\ContentCore\Page\Api\Action\PublishPageTemplateCmsResource;
use Zrcms\ContentCore\Page\Api\Action\UnpublishPageCmsResource;
use Zrcms\ContentCore\Page\Api\Action\UnpublishPageTemplateCmsResource;
use Zrcms\ContentCore\Page\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageDraftCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageCmsResource;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageTemplateCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\CmsResource\FindPageTemplateCmsResourcesBy;
use Zrcms\ContentCore\Page\Api\Content\FindPageVersion;
use Zrcms\ContentCore\Page\Api\Content\FindPageVersionsBy;
use Zrcms\ContentCore\Page\Api\Content\InsertPageVersion;
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
                    GetChangeLogByDateRange::class => [
                        'class' => This\Page\Api\ChangeLog\GetChangeLogByDateRange::class,
                        'arguments' => [EntityManager::class]
                    ],
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
                        'class' => This\Page\Api\CmsResource\FindPageCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageCmsResourceBySitePath::class => [
                        'class' => This\Page\Api\CmsResource\FindPageCmsResourceBySitePath::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageCmsResourcesBy::class => [
                        'class' => This\Page\Api\CmsResource\FindPageCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageVersion::class => [
                        'class' => This\Page\Api\Content\FindPageVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageVersionsBy::class => [
                        'class' => This\Page\Api\Content\FindPageVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageTemplateCmsResourceBySitePath::class => [
                        'class' => This\Page\Api\CmsResource\FindPageTemplateCmsResourceBySitePath::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageTemplateCmsResourcesBy::class => [
                        'class' => This\Page\Api\CmsResource\FindPageTemplateCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertPageVersion::class => [
                        'class' => This\Page\Api\Content\InsertPageVersion::class,
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
