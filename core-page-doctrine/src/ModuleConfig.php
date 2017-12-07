<?php

namespace Zrcms\CorePageDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\CorePage\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\CorePage\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageDraftCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourcesBy;
use Zrcms\CorePage\Api\Content\FindPageVersion;
use Zrcms\CorePage\Api\Content\FindPageVersionsBy;
use Zrcms\CorePage\Api\Content\InsertPageVersion;
use Zrcms\CorePageDoctrine as This;

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
                    UpsertPageCmsResource::class => [
                        'class' => This\Api\CmsResource\UpsertPageCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UpsertPageTemplateCmsResource::class => [
                        'class' => This\Api\CmsResource\UpsertPageTemplateCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UpsertPageDraftCmsResource::class => [
                        'class' => This\Api\CmsResource\UpsertPageDraftCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageCmsResource::class => [
                        'class' => This\Api\CmsResource\FindPageCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageCmsResourceBySitePath::class => [
                        'class' => This\Api\CmsResource\FindPageCmsResourceBySitePath::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageCmsResourcesBy::class => [
                        'class' => This\Api\CmsResource\FindPageCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageVersion::class => [
                        'class' => This\Api\Content\FindPageVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageVersionsBy::class => [
                        'class' => This\Api\Content\FindPageVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageTemplateCmsResourceBySitePath::class => [
                        'class' => This\Api\CmsResource\FindPageTemplateCmsResourceBySitePath::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindPageTemplateCmsResourcesBy::class => [
                        'class' => This\Api\CmsResource\FindPageTemplateCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertPageVersion::class => [
                        'class' => This\Api\Content\InsertPageVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                ],
            ],
            'doctrine' => [
                'driver' => [
                    'Zrcms\CorePageDoctrine' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Page/Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\CorePageDoctrine'
                            => 'Zrcms\CorePageDoctrine'
                        ]
                    ]
                ],
            ],
        ];
    }
}
