<?php

namespace Zrcms\CorePageDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\CorePage\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageDraftCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageTemplateCmsResource;
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
                    GetChangeLogByDateRange::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\ChangeLog\GetChangeLogByDateRangeAbstract::class,
                        'arguments' => [EntityManager::class]
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
                    UpsertPageCmsResource::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\UpsertPageCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    UpsertPageDraftCmsResource::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\UpsertPageDraftCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    UpsertPageTemplateCmsResource::class => [
                        'class' => \Zrcms\CorePageDoctrine\Api\CmsResource\UpsertPageTemplateCmsResource::class,
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
