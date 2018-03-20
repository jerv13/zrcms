<?php

namespace Zrcms\CoreRedirectDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\CoreRedirect\Api\ChangeLog\GetRedirectChangeLogByDateRange;
use Zrcms\CoreRedirect\Api\CmsResource\CreateRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourceBySiteRequestPath;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourcesBy;
use Zrcms\CoreRedirect\Api\CmsResource\UpdateRedirectCmsResource;
use Zrcms\CoreRedirect\Api\Content\FindRedirectVersion;
use Zrcms\CoreRedirect\Api\Content\FindRedirectVersionsBy;
use Zrcms\CoreRedirect\Api\Content\InsertRedirectVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    GetRedirectChangeLogByDateRange::class => [
                        'class' => \Zrcms\CoreRedirectDoctrine\Api\ChangeLog\GetRedirectChangeLogByDateRangeAbstract::class,
                        'arguments' => [EntityManager::class]
                    ],

                    CreateRedirectCmsResource::class => [
                        'class' => \Zrcms\CoreRedirectDoctrine\Api\CmsResource\CreateRedirectCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResource::class => [
                        'class' => \Zrcms\CoreRedirectDoctrine\Api\CmsResource\FindRedirectCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResourceBySiteRequestPath::class => [
                        'class'
                        => \Zrcms\CoreRedirectDoctrine\Api\CmsResource\FindRedirectCmsResourceBySiteRequestPath::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResourcesBy::class => [
                        'class' => \Zrcms\CoreRedirectDoctrine\Api\CmsResource\FindRedirectCmsResourcesBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    UpdateRedirectCmsResource::class => [
                        'class' => \Zrcms\CoreRedirectDoctrine\Api\CmsResource\UpdateRedirectCmsResource::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],

                    FindRedirectVersion::class => [
                        'class' => \Zrcms\CoreRedirectDoctrine\Api\Content\FindRedirectVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    FindRedirectVersionsBy::class => [
                        'class' => \Zrcms\CoreRedirectDoctrine\Api\Content\FindRedirectVersionsBy::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                    InsertRedirectVersion::class => [
                        'class' => \Zrcms\CoreRedirectDoctrine\Api\Content\InsertRedirectVersion::class,
                        'arguments' => [
                            EntityManager::class,
                        ],
                    ],
                ],
            ],

            'doctrine' => [
                'driver' => [
                    'Zrcms\CoreRedirectDoctrine' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Entity'
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\CoreRedirectDoctrine' => 'Zrcms\CoreRedirectDoctrine'
                        ]
                    ]
                ],
            ],
        ];
    }
}
