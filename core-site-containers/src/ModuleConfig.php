<?php

namespace Zrcms\CoreSiteContainer;

use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;
use Zrcms\CoreSiteContainer\Api\CmsResource\CreateSiteContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBy;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBySiteNames;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesPublished;
use Zrcms\CoreSiteContainer\Api\CmsResource\UpdateSiteContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\CmsResourceHistory\FindSiteContainerCmsResourceHistory;
use Zrcms\CoreSiteContainer\Api\CmsResourceHistory\FindSiteContainerCmsResourceHistoryBy;
use Zrcms\CoreSiteContainer\Api\Content\FindSiteContainerVersion;
use Zrcms\CoreSiteContainer\Api\Content\FindSiteContainerVersionsBy;
use Zrcms\CoreSiteContainer\Api\Content\InsertSiteContainerVersion;

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
                    CreateSiteContainerCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteContainerCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteContainerCmsResourcesBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteContainerCmsResourcesBySiteNames::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteContainerCmsResourcesPublished::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    UpdateSiteContainerCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    FindSiteContainerCmsResourceHistory::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteContainerCmsResourceHistoryBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * ContentVersion
                     */
                    FindSiteContainerVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindSiteContainerVersionsBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    InsertSiteContainerVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                ],
            ],
        ];
    }
}
