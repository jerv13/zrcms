<?php

namespace Zrcms\HttpRedirectDoctrineDataSource;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zrcms\HttpRedirect\Redirect\Api\Action\PublishRedirectCmsResource;
use Zrcms\HttpRedirect\Redirect\Api\Action\UnpublishRedirectCmsResource;
use Zrcms\HttpRedirect\Redirect\Api\Repository\FindRedirectCmsResource;
use Zrcms\HttpRedirect\Redirect\Api\Repository\FindRedirectCmsResourcesBy;
use Zrcms\HttpRedirect\Redirect\Api\Repository\FindRedirectVersion;
use Zrcms\HttpRedirect\Redirect\Api\Repository\FindRedirectVersionsBy;
use Zrcms\HttpRedirect\Redirect\Api\Repository\InsertRedirectVersion;
use Zrcms\HttpRedirectDoctrineDataSource as This;

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

                    /**
                     * Redirect ===========================================
                     */
                    PublishRedirectCmsResource::class => [
                        'class' => This\Redirect\Api\Action\PublishRedirectCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    UnpublishRedirectCmsResource::class => [
                        'class' => This\Redirect\Api\Action\UnpublishRedirectCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResource::class => [
                        'class' => This\Redirect\Api\Repository\FindRedirectCmsResource::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectCmsResourcesBy::class => [
                        'class' => This\Redirect\Api\Repository\FindRedirectCmsResourcesBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectVersion::class => [
                        'class' => This\Redirect\Api\Repository\FindRedirectVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    FindRedirectVersionsBy::class => [
                        'class' => This\Redirect\Api\Repository\FindRedirectVersionsBy::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                    InsertRedirectVersion::class => [
                        'class' => This\Redirect\Api\Repository\InsertRedirectVersion::class,
                        'arguments' => [
                            '0-' => EntityManager::class,
                        ],
                    ],
                ],
                'doctrine' => [
                    'driver' => [
                        'Zrcms\HttpRedirectDoctrineDataSource' => [
                            'class' => AnnotationDriver::class,
                            'cache' => 'array',
                            'paths' => [
                                __DIR__ . '/Entity'
                            ]
                        ],
                        'orm_default' => [
                            'drivers' => [
                                'Zrcms\HttpRedirectDoctrineDataSource' => 'Zrcms\HttpRedirectDoctrineDataSource'
                            ]
                        ]
                    ],
                ],
            ];
    }
}
