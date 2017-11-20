<?php

namespace Zrcms\ContentRedirectDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\ContentRedirect\Api\CmsResource\UpsertRedirectCmsResource;
use Zrcms\ContentRedirect\Api\Repository\FindRedirectCmsResource;
use Zrcms\ContentRedirect\Api\Repository\FindRedirectCmsResourceBySiteRequestPath;
use Zrcms\ContentRedirect\Api\Repository\FindRedirectCmsResourcesBy;
use Zrcms\ContentRedirect\Api\Repository\FindRedirectVersion;
use Zrcms\ContentRedirect\Api\Repository\FindRedirectVersionsBy;
use Zrcms\ContentRedirect\Api\Repository\InsertRedirectVersion;
use Zrcms\ContentRedirectDoctrineDataSource as This;

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
                    UpsertRedirectCmsResource::class => [
                        'class' => This\Api\CmsResource\UpsertRedirectCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResource::class => [
                        'class' => This\Api\Repository\FindRedirectCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResourceBySiteRequestPath::class => [
                        'class' => This\Api\Repository\FindRedirectCmsResourceBySiteRequestPath::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResourcesBy::class => [
                        'class' => This\Api\Repository\FindRedirectCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectVersion::class => [
                        'class' => This\Api\Repository\FindRedirectVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectVersionsBy::class => [
                        'class' => This\Api\Repository\FindRedirectVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertRedirectVersion::class => [
                        'class' => This\Api\Repository\InsertRedirectVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                ],
            ],

            'doctrine' => [
                'driver' => [
                    'Zrcms\ContentRedirectDoctrineDataSource' => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/Entity'
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            'Zrcms\ContentRedirectDoctrineDataSource' => 'Zrcms\ContentRedirectDoctrineDataSource'
                        ]
                    ]
                ],
            ],
        ];
    }
}
