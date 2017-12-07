<?php

namespace Zrcms\CoreRedirectDoctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\CoreRedirect\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\CoreRedirect\Api\CmsResource\UpsertRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourceBySiteRequestPath;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourcesBy;
use Zrcms\CoreRedirect\Api\Content\FindRedirectVersion;
use Zrcms\CoreRedirect\Api\Content\FindRedirectVersionsBy;
use Zrcms\CoreRedirect\Api\Content\InsertRedirectVersion;
use Zrcms\CoreRedirectDoctrine as This;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    GetChangeLogByDateRange::class => [
                        'class' => This\Api\ChangeLog\GetChangeLogByDateRange::class,
                        'arguments' => [EntityManager::class]
                    ],
                    UpsertRedirectCmsResource::class => [
                        'class' => This\Api\CmsResource\UpsertRedirectCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResource::class => [
                        'class' => This\Api\CmsResource\FindRedirectCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResourceBySiteRequestPath::class => [
                        'class' => This\Api\CmsResource\FindRedirectCmsResourceBySiteRequestPath::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResourcesBy::class => [
                        'class' => This\Api\CmsResource\FindRedirectCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectVersion::class => [
                        'class' => This\Api\Content\FindRedirectVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectVersionsBy::class => [
                        'class' => This\Api\Content\FindRedirectVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertRedirectVersion::class => [
                        'class' => This\Api\Content\InsertRedirectVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
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
