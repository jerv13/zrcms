<?php

namespace Zrcms\HttpApiSite;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\HttpApiSite\Acl\IsAllowedFindContentVersion;
use Zrcms\HttpApiSite\Acl\IsAllowedSiteCmsResourceFind;
use Zrcms\HttpApiSite\Acl\IsAllowedSitePublish;
use Zrcms\HttpApiSite\Acl\IsAllowedSiteUnpublish;
use Zrcms\HttpApiSite\CmsResource\FindSiteCmsResource;
use Zrcms\HttpApiSite\Content\FindSiteVersion;
use Zrcms\HttpApiSite\Content\InsertSiteVersion;
use Zrcms\HttpApiSite\Validate\UpsertSiteCmsResourceZfInputFilterService;
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
                    IsAllowedFindContentVersion::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-repository-find-cms-resource'],
                        ],
                    ],
                    IsAllowedSiteCmsResourceFind::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-repository-find-cms-resource'],
                        ],
                    ],
                    IsAllowedSitePublish::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-upsert-publish-cms-resource'],
                        ],
                    ],
                    IsAllowedSiteUnpublish::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'site-upsert-unpublish-cms-resource'],
                        ],
                    ],
                    /**
                     * Repository ===========================================
                     */
                    FindSiteCmsResource::class => [
                        'arguments' => [
                            \Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource::class,
                            CmsResourceToArray::class,
                            ['literal' => SiteCmsResourceBasic::class],
                            ['literal' => 'site-repository-find-cms-resource'],
                        ],
                    ],
                    FindSiteVersion::class => [
                        'arguments' => [
                            \Zrcms\CoreSite\Api\Content\FindSiteVersion::class,
                            ContentVersionToArray::class,
                            ['literal' => 'site-repository-find-content-version'],
                        ],
                    ],
                    InsertSiteVersion::class => [
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
                    UpsertSiteCmsResourceZfInputFilterService::class => [
                        'arguments' => [
                            ServiceAwareFactory::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
