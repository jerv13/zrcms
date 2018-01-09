<?php

namespace Zrcms\HttpApiSite;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedFindContentVersionIsAllowed;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedSiteCmsResourceFindIsAllowed;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedSitePublishIsAllowed;
use Zrcms\HttpApiSite\Acl\HttpApiIsAllowedSiteUnpublishIsAllowed;
use Zrcms\HttpApiSite\CmsResource\HttpApiFindSiteCmsResource;
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
                            ['literal' => 'site-repository-find-cms-resource'],
                        ],
                    ],
                    HttpApiIsAllowedSiteCmsResourceFindIsAllowed::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-repository-find-cms-resource'],
                        ],
                    ],
                    HttpApiIsAllowedSitePublishIsAllowed::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-upsert-publish-cms-resource'],
                        ],
                    ],
                    HttpApiIsAllowedSiteUnpublishIsAllowed::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-upsert-unpublish-cms-resource'],
                        ],
                    ],
                    /**
                     * Repository ===========================================
                     */
                    HttpApiFindSiteCmsResource::class => [
                        'arguments' => [
                            \Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource::class,
                            CmsResourceToArray::class,
                            ['literal' => SiteCmsResourceBasic::class],
                            ['literal' => 'site-repository-find-cms-resource'],
                        ],
                    ],
                    HttpApiFindSiteVersion::class => [
                        'arguments' => [
                            \Zrcms\CoreSite\Api\Content\FindSiteVersion::class,
                            ContentVersionToArray::class,
                            ['literal' => 'site-repository-find-content-version'],
                        ],
                    ],
                    HttpApiInsertSiteVersion::class => [
                        'arguments' => [
                            \Zrcms\Core\Api\Content\InsertContentVersion::class,
                            ContentVersionToArray::class,
                            GetUserIdByRequest::class,
                            ['literal' => SiteVersionBasic::class],
                            ['literal' => 'site-repository-insert-content-version'],
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
