<?php

namespace Zrcms\ContentCore;

use Zrcms\ContentCore\Site\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceByRequest;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResource;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResourcesBy;
use Zrcms\ContentCore\Site\Api\Content\FindSiteVersion;
use Zrcms\ContentCore\Site\Api\Content\FindSiteVersionsBy;
use Zrcms\ContentCore\Site\Api\Content\InsertSiteVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigSite
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    /**
                     * Site ===========================================
                     */
                    UpsertSiteCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UpsertSiteCmsResource::class],
                        ],
                    ],
                    FindSiteCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteCmsResource::class],
                        ],
                    ],
                    FindSiteCmsResourceByHost::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteCmsResourceByHost::class],
                        ],
                    ],
                    FindSiteCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteCmsResourcesBy::class],
                        ],
                    ],
                    FindSiteVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteVersion::class],
                        ],
                    ],
                    FindSiteVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteVersionsBy::class],
                        ],
                    ],
                    InsertSiteVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertSiteVersion::class],
                        ],
                    ],

                    GetSiteCmsResourceByRequest::class => [
                        'arguments' => [
                            '0-' => FindSiteCmsResourceByHost::class,
                        ],
                    ],
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [

            ],
        ];
    }
}
