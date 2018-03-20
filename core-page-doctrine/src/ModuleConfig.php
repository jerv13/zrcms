<?php

namespace Zrcms\CorePageDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\CorePage\Api\ChangeLog\GetPageChangeLogByDateRange;
use Zrcms\CorePage\Api\CmsResource\CreatePageCmsResource;
use Zrcms\CorePage\Api\CmsResource\CreatePageDraftCmsResource;
use Zrcms\CorePage\Api\CmsResource\CreatePageTemplateCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\UpdatePageCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpdatePageDraftCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpdatePageTemplateCmsResource;
use Zrcms\CorePage\Api\CmsResourceHistory\FindPageCmsResourceHistoryBy;
use Zrcms\CorePage\Api\Content\FindPageVersion;
use Zrcms\CorePage\Api\Content\FindPageVersionsBy;
use Zrcms\CorePage\Api\Content\InsertPageVersion;

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
                    GetPageChangeLogByDateRange::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\ChangeLog\GetPageChangeLogByDateRangeAbstract::class,
                        'arguments' => [EntityManager::class]
                    ],

                    CreatePageCmsResource::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\CreatePageCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    CreatePageDraftCmsResource::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\CreatePageDraftCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    CreatePageTemplateCmsResource::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\CreatePageTemplateCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindPageCmsResource::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\FindPageCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindPageCmsResourceBySitePath::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\FindPageCmsResourceBySitePath::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindPageCmsResourcesBy::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\FindPageCmsResourcesBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindPageTemplateCmsResourceBySitePath::class => [
                        'class'
                        => \Zrcms\CorePageDoctrine\Api\CmsResource\FindPageTemplateCmsResourceBySitePath::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindPageTemplateCmsResourcesBy::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\FindPageTemplateCmsResourcesBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    UpdatePageCmsResource::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\UpdatePageCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    UpdatePageDraftCmsResource::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\UpdatePageDraftCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    UpdatePageTemplateCmsResource::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\UpdatePageTemplateCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],

                    FindPageCmsResourceHistoryBy::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResourceHistory\FindPageCmsResourceHistoryBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],

                    FindPageVersion::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\Content\FindPageVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindPageVersionsBy::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\Content\FindPageVersionsBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    InsertPageVersion::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\Content\InsertPageVersion::class,
                        'arguments' => [
                            EntityManager::class,
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
                            __DIR__ . '/Entity',
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
