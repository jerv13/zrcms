<?php

namespace Zrcms\CoreSite;

use Zrcms\Core\Exception\IMPLEMENTATION_REQUIRED;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesBy;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\CoreSite\Api\Content\FindSiteVersion;
use Zrcms\CoreSite\Api\Content\FindSiteVersionsBy;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;

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
                    /**
                     * Site ===========================================
                     */
                    UpsertSiteCmsResource::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindSiteCmsResource::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindSiteCmsResourceByHost::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindSiteCmsResourcesBy::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindSiteVersion::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindSiteVersionsBy::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    InsertSiteVersion::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],

                    GetSiteCmsResourceByRequest::class => [
                        'arguments' => [
                            FindSiteCmsResourceByHost::class,
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
