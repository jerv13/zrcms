<?php

namespace Zrcms\CoreRedirect;

use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;
use Zrcms\CoreRedirect\Api\CmsResource\CreateRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourceBySiteRequestPath;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourcesBy;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourcesPublished;
use Zrcms\CoreRedirect\Api\CmsResource\UpsertRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResourceHistory\FindRedirectCmsResourceHistory;
use Zrcms\CoreRedirect\Api\CmsResourceHistory\FindRedirectCmsResourceHistoryBy;
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
                    /**
                     * CmsResource
                     */
                    CreateRedirectCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindRedirectCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindRedirectCmsResourceBySiteRequestPath::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindRedirectCmsResourcesBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindRedirectCmsResourcesPublished::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    UpsertRedirectCmsResource::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    FindRedirectCmsResourceHistory::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindRedirectCmsResourceHistoryBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * ContentVersion
                     */
                    FindRedirectVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindRedirectVersionsBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    InsertRedirectVersion::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                ],
            ],
        ];
    }
}
