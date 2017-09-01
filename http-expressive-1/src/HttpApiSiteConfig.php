<?php

namespace Zrcms\HttpExpressive1;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Content\Api\CmsResourceToArray;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\HttpExpressive1\HttpAcl\IsAllowedCheck;
use Zrcms\HttpExpressive1\HttpAcl\IsAllowedSiteCmsResourceFind;
use Zrcms\HttpExpressive1\HttpAcl\IsAllowedSitePublish;
use Zrcms\HttpExpressive1\HttpAcl\IsAllowedSiteUnpublish;
use Zrcms\HttpExpressive1\HttpApi\Site\Action\PublishSiteCmsResource;
use Zrcms\HttpExpressive1\HttpApi\Site\Action\UnpublishSiteCmsResource;
use Zrcms\HttpExpressive1\HttpApi\Site\Repository\FindSiteCmsResource;
use Zrcms\HttpExpressive1\HttpApi\Site\Repository\FindSiteVersion;
use Zrcms\HttpExpressive1\HttpApi\Site\Repository\InsertSiteVersion;
use Zrcms\HttpExpressive1\HttpValidator\IdAttributeZfInputFilterService;
use Zrcms\HttpExpressive1\HttpValidator\SiteCmsResourcePublishZfInputFilterService;
use Zrcms\HttpExpressive1\HttpValidator\SiteCmsResourceUnpublishZfInputFilterService;
use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\HttpResponseHandler\Api\HandleResponseApiMessages;
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
                     * HttpAcl ===========================================
                     */
                    IsAllowedSiteCmsResourceFind::class=> [
                        'arguments' => [
                            HandleResponse::class,
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
                            HandleResponse::class,
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
                            HandleResponse::class,
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
                     * HttpApi ===========================================
                     */
                    PublishSiteCmsResource::class => [
                        'arguments' => [
                            \Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource::class,
                            CmsResourceToArray::class,
                            GetUserIdByRequest::class,
                            HandleResponseApi::class,
                            ['literal' => SiteCmsResourceBasic::class],
                            ['literal' => 'site-action-publish-cms-resource'],
                        ],
                    ],
                    UnpublishSiteCmsResource::class => [
                        'arguments' => [
                            \Zrcms\ContentCore\Site\Api\Action\UnpublishSiteCmsResource::class,
                            GetUserIdByRequest::class,
                            HandleResponseApi::class,
                            ['literal' => 'site-action-unpublish-cms-resource'],
                        ],
                    ],
                    FindSiteCmsResource::class => [
                        'arguments' => [
                            \Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource::class,
                            CmsResourceToArray::class,
                            HandleResponseApi::class,
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
                     * HttpValidator ===========================================
                     */
                    SiteCmsResourcePublishZfInputFilterService::class => [
                        'arguments' => [
                            ServiceAwareFactory::class,
                            HandleResponseApiMessages::class,
                        ],
                    ],
                ],
            ],
            'routes' => [
                /**
                 * Site ===========================================
                 */

                // Publish CmsResource
                'zrcms.site.action.publish-cms-resource' => [
                    'name' => 'zrcms.site.action.publish-cms-resource',
                    'path' => '/zrcms/site/action/publish-cms-resource',
                    'middleware' => [
                        'parser' => BodyParamsMiddleware::class,
                        'acl' => IsAllowedSitePublish::class,
                        'validator-data' => SiteCmsResourcePublishZfInputFilterService::class,
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
                'zrcms.site.repository.find-cms-resource' => [
                    'name' => 'zrcms.site.repository.find-cms-resource',
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
                'zrcms.site.repository.find-content-version' => [
                    'name' => 'zrcms.site.repository.find-content-version',
                    'path' => '/zrcms/site/repository/find-content-version/{id}',
                    'middleware' => [
                        'acl' => IsAllowedCheck::class,
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
