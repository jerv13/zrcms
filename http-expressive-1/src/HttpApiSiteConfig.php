<?php

namespace Zrcms\HttpExpressive1;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Content\Api\CmsResourceToArray;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\HttpExpressive1\HttpApi\Validate\IdAttributeZfInputFilterService;
use Zrcms\HttpExpressive1\HttpApiSite\Acl\IsAllowedFindContentVersion;
use Zrcms\HttpExpressive1\HttpApiSite\Acl\IsAllowedSiteCmsResourceFind;
use Zrcms\HttpExpressive1\HttpApiSite\Acl\IsAllowedSitePublish;
use Zrcms\HttpExpressive1\HttpApiSite\Acl\IsAllowedSiteUnpublish;
use Zrcms\HttpExpressive1\HttpApiSite\Action\PublishSiteCmsResource;
use Zrcms\HttpExpressive1\HttpApiSite\Action\UnpublishSiteCmsResource;
use Zrcms\HttpExpressive1\HttpApiSite\Repository\FindSiteCmsResource;
use Zrcms\HttpExpressive1\HttpApiSite\Repository\FindSiteVersion;
use Zrcms\HttpExpressive1\HttpApiSite\Repository\InsertSiteVersion;
use Zrcms\HttpExpressive1\HttpApiSite\Validate\PublishSiteCmsResourceZfInputFilterService;
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
                            ['literal' => 'site-action-publish-cms-resource'],
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
                            ['literal' => 'site-action-unpublish-cms-resource'],
                        ],
                    ],
                    /**
                     * Action ===========================================
                     */
                    PublishSiteCmsResource::class => [
                        'arguments' => [
                            \Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource::class,
                            \Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion::class,
                            CmsResourceToArray::class,
                            GetUserIdByRequest::class,
                            ['literal' => SiteCmsResourceBasic::class],
                            ['literal' => SiteVersionBasic::class],
                            ['literal' => 'site-action-publish-cms-resource'],
                        ],
                    ],
                    UnpublishSiteCmsResource::class => [
                        'arguments' => [
                            \Zrcms\ContentCore\Site\Api\Action\UnpublishSiteCmsResource::class,
                            GetUserIdByRequest::class,
                            ['literal' => 'site-action-unpublish-cms-resource'],
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
                // Publish CmsResource
                'zrcms.site.action.publish-cms-resource' => [
                    'name' => 'zrcms.site.action.publish-cms-resource',
                    'path' => '/zrcms/site/action/publish-cms-resource',
                    'middleware' => [
                        'parser' => BodyParamsMiddleware::class,
                        'acl' => IsAllowedSitePublish::class,
                        'validator-data' => PublishSiteCmsResourceZfInputFilterService::class,
                        'api' => PublishSiteCmsResource::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['POST'],
                ],

                // Unpublish CmsResource
                'zrcms.site.action.unpublish-cms-resource.id' => [
                    'name' => 'zrcms.site.action.unpublish-cms-resource.id',
                    'path' => '/zrcms/site/action/unpublish-cms-resource/{id}',
                    'middleware' => [
                        'acl' => IsAllowedSiteUnpublish::class,
                        'validator-attributes' => IdAttributeZfInputFilterService::class,
                        'api' => UnpublishSiteCmsResource::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['POST'],
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
