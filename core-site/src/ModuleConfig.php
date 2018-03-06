<?php

namespace Zrcms\CoreSite;

use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;
use Zrcms\CoreSite\Api\CmsResource\CreateSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourceByHost;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesBy;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesPublished;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResourceHistory\FindLastSiteCmsResourceHistory;
use Zrcms\CoreSite\Api\CmsResourceHistory\FindSiteCmsResourceHistory;
use Zrcms\CoreSite\Api\CmsResourceHistory\FindSiteCmsResourceHistoryBy;
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
                     * CmsResource
                     */
                    CreateSiteCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteCmsResourceByHost::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteCmsResourcesBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteCmsResourcesPublished::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    UpsertSiteCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    FindLastSiteCmsResourceHistory::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteCmsResourceHistory::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteCmsResourceHistoryBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * ContentVersion
                     */
                    FindSiteVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteVersionsBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    InsertSiteVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    GetSiteCmsResourceByRequest::class => [
                        'arguments' => [
                            FindSiteCmsResourceByHost::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
