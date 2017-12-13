<?php

namespace Zrcms\HttpCoreSite;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\HttpCoreSite\Acl\IsAllowedFindContentVersion;
use Zrcms\HttpCoreSite\Acl\IsAllowedSiteCmsResourceFind;
use Zrcms\HttpCoreSite\Acl\IsAllowedSitePublish;
use Zrcms\HttpCoreSite\Acl\IsAllowedSiteUnpublish;
use Zrcms\HttpCoreSite\CmsResource\FindSiteCmsResource;
use Zrcms\HttpCoreSite\Content\FindSiteVersion;
use Zrcms\HttpCoreSite\Content\InsertSiteVersion;
use Zrcms\HttpCoreSite\Validate\UpsertSiteCmsResourceZfInputFilterService;
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
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'sites',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'admin'
                                ]
                            ],
                            ['literal' => 'site-repository-find-cms-resource'],
                        ],
                    ],
                    IsAllowedSiteCmsResourceFind::class => [
                        'arguments' => [
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'sites',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'admin'
                                ]
                            ],
                            ['literal' => 'site-repository-find-cms-resource'],
                        ],
                    ],
                    IsAllowedSitePublish::class => [
                        'arguments' => [
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'sites',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'admin'
                                ]
                            ],
                            ['literal' => 'site-upsert-publish-cms-resource'],
                        ],
                    ],
                    IsAllowedSiteUnpublish::class => [
                        'arguments' => [
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'sites',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'admin'
                                ]
                            ],
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
