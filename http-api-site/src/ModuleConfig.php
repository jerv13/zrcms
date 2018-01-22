<?php

namespace Zrcms\HttpApiSite;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedFindContentVersionIsAllowed;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedSiteCmsResourceFindIsAllowed;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedSitePublishIsAllowed;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedSiteUnpublishIsAllowed;
use Zrcms\HttpApiSite\Content\HttpApiFindSiteVersion;
use Zrcms\HttpApiSite\Content\HttpApiInsertSiteVersion;
use Zrcms\HttpApiSite\Validate\HttpApiUpsertSiteCmsResourceZfInputFilterServiceHttpApi;
use Zrcms\User\Api\GetUserIdByRequest;

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
                     * Acl ===========================================
                     */
                    HttpApiIsAllowedFindContentVersionIsAllowed::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-find-cms-resource'],
                            ['literal' => 401],
                            ['literal' => IsDebug::invoke()]
                        ],
                    ],
                    HttpApiIsAllowedSiteCmsResourceFindIsAllowed::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-find-cms-resource'],
                            ['literal' => 401],
                            ['literal' => IsDebug::invoke()]
                        ],
                    ],
                    HttpApiIsAllowedSitePublishIsAllowed::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-upsert-publish-cms-resource'],
                            ['literal' => 401],
                            ['literal' => IsDebug::invoke()]
                        ],
                    ],
                    HttpApiIsAllowedSiteUnpublishIsAllowed::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-upsert-unpublish-cms-resource'],
                            ['literal' => 401],
                            ['literal' => IsDebug::invoke()]
                        ],
                    ],
                    /**
                     * Repository ===========================================
                     */
                    HttpApiFindSiteVersion::class => [
                        'arguments' => [
                            \Zrcms\CoreSite\Api\Content\FindSiteVersion::class,
                            ContentVersionToArray::class,
                            ['literal' => 'site-find-content-version'],
                        ],
                    ],
                    HttpApiInsertSiteVersion::class => [
                        'arguments' => [
                            \Zrcms\Core\Api\Content\InsertContentVersion::class,
                            ContentVersionToArray::class,
                            GetUserIdByRequest::class,
                            ['literal' => SiteVersionBasic::class],
                            ['literal' => 'site-insert-content-version'],
                        ],
                    ],
                    /**
                     * Validate ===========================================
                     */
                    HttpApiUpsertSiteCmsResourceZfInputFilterServiceHttpApi::class => [
                        'arguments' => [
                            ServiceAwareFactory::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
