<?php

namespace Zrcms\HttpExpressive;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Content\Api\CmsResourceToArray;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\ContentCore\Site\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\HttpExpressive\HttpApi\Acl\IsAllowedCheckApi;
use Zrcms\HttpExpressive\HttpApi\Validate\IdAttributeZfInputFilterService;
use Zrcms\HttpExpressive\HttpApiSite\Acl\IsAllowedFindContentVersion;
use Zrcms\HttpExpressive\HttpApiSite\Acl\IsAllowedSiteCmsResourceFind;
use Zrcms\HttpExpressive\HttpApiSite\Acl\IsAllowedSitePublish;
use Zrcms\HttpExpressive\HttpApiSite\Acl\IsAllowedSiteUnpublish;
use Zrcms\HttpExpressive\HttpApiSite\Repository\FindSiteCmsResource;
use Zrcms\HttpExpressive\HttpApiSite\Repository\FindSiteVersion;
use Zrcms\HttpExpressive\HttpApiSite\Repository\InsertSiteVersion;
use Zrcms\HttpExpressive\HttpApiSite\Validate\PublishSiteCmsResourceZfInputFilterService;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiSiteConfig
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
                            \Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource::class,
                            CmsResourceToArray::class,
                            ['literal' => SiteCmsResourceBasic::class],
                            ['literal' => 'site-repository-find-cms-resource'],
                        ],
                    ],
                    FindSiteVersion::class => [
                        'arguments' => [
                            \Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion::class,
                            ContentVersionToArray::class,
                            ['literal' => 'site-repository-find-content-version'],
                        ],
                    ],
                    InsertSiteVersion::class => [
                        'arguments' => [
                            \Zrcms\Content\Api\Repository\InsertContentVersion::class,
                            ContentVersionToArray::class,
                            GetUserIdByRequest::class,
                            ['literal' => SiteVersionBasic::class],
                            ['literal' => 'site-repository-insert-content-version'],
                        ],
                    ],
                    /**
                     * Validate ===========================================
                     */
                    PublishSiteCmsResourceZfInputFilterService::class => [
                        'arguments' => [
                            ServiceAwareFactory::class,
                        ],
                    ],
                ],
            ],
            'routes' => [
                // Upsert CmsResource
                'zrcms.site.cms-resource' => [
                    'name' => 'zrcms.site.cms-resource',
                    'path' => '/zrcms/site/cms-resource',
                    'middleware' => [
                        'parser' => BodyParamsMiddleware::class,
                        'acl' => IsAllowedSitePublish::class,
                        'validator-data' => PublishSiteCmsResourceZfInputFilterService::class,
                        'api' => UpsertSiteCmsResource::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['PUT'],
                ],

                // Find CmsResource
                'zrcms.site.repository.find-cms-resource.id' => [
                    'name' => 'zrcms.site.repository.find-cms-resource.id',
                    'path' => '/zrcms/site/repository/find-cms-resource/{id}',
                    'middleware' => [
                        'acl' => IsAllowedSiteCmsResourceFind::class,
                        'validator-attributes' => IdAttributeZfInputFilterService::class,
                        'api' => FindSiteCmsResource::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],

                // Find ContentVersion
                'zrcms.site.repository.find-content-version.id' => [
                    'name' => 'zrcms.site.repository.find-content-version.id',
                    'path' => '/zrcms/site/repository/find-content-version/{id}',
                    'middleware' => [
                        'acl' => IsAllowedFindContentVersion::class,
                        'validator-attributes' => IdAttributeZfInputFilterService::class,
                        'api' => FindSiteVersion::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
