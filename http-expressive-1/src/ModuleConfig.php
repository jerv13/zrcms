<?php

namespace Zrcms\HttpExpressive1;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigApplicationConfig;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceVersionByRequest;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;
use Zrcms\ContentRedirectDoctrineDataSource\Api\Repository\FindRedirectCmsResourceVersionBySiteRequestPath;
use Zrcms\HttpExpressive1\Api\View\Render\GetViewLayoutMetaPageData;
use Zrcms\HttpExpressive1\ApiHttp\Site\Repository\FindSiteVersion;
use Zrcms\HttpExpressive1\ApiHttp\Site\Repository\InsertSiteVersion;
use Zrcms\HttpExpressive1\Middleware\AclHttp;
use Zrcms\HttpExpressive1\Middleware\AttributesZfInputFilterService;
use Zrcms\HttpExpressive1\Middleware\ContentRedirect;
use Zrcms\HttpExpressive1\Middleware\DataZfInputFilterService;
use Zrcms\HttpExpressive1\Middleware\LocaleFromSite;
use Zrcms\HttpExpressive1\Middleware\ParamLogOut;
use Zrcms\HttpExpressive1\Middleware\ParamQuery;
use Zrcms\HttpExpressive1\Model\HttpExpressiveComponent;
use Zrcms\HttpExpressive1\Model\PropertiesHttpExpressiveComponent;
use Zrcms\HttpExpressive1\Render\ViewController;
use Zrcms\HttpExpressive1\Render\ViewControllerFallbackPage;
use Zrcms\HttpExpressive1\Render\ViewControllerTest;
use Zrcms\HttpExpressive1\Render\ViewControllerTestFactory;
use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Api\HandleResponseApiMessages;
use Zrcms\HttpResponseHandler\Api\HandleResponseReturnOnStatus;
use Zrcms\Locale\Api\SetLocale;
use Zrcms\User\Api\GetUserIdByRequest;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
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
                     * Api ===========================================
                     */
                    GetViewLayoutMetaPageData::class => [
                        'arguments' => [
                            RenderTag::class,
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'sites',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'admin',
                                ]
                            ],
                        ],
                    ],
                    /**
                     * ApiHttp ===========================================
                     */
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
                     * Middleware ===========================================
                     */
                    /* ACL EXAMPLE *
                    AclHttp::class => [
                        'arguments' => [
                            HandleResponse::class,
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'admin',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'read'
                                ]
                            ]
                        ],
                    ],
                    /* */

                    /* Attribute Validator EXAMPLE *
                    AttributesZfInputFilterService::class => [
                        'arguments' => [
                            ServiceAwareFactory::class,
                            [
                                'literal' => [
                                    // zf-input-filter-service config
                                    'test1' => [
                                        'name' => 'test1',
                                        'required' => true,
                                        'validators' => [
                                            [
                                                // Invoked
                                                'name' => 'ZfInputFilterService\Validator\Test',
                                                'options' => [
                                                    'test' => 'validatorOptionInvoked',
                                                    'messages' => [
                                                        'TEST' => 'validatorMessageTemplateInvoked',
                                                    ],
                                                ],
                                            ],
                                            [
                                                // Service
                                                'name' => 'ZfInputFilterService\Validator\TestService',
                                                'service' => true,
                                                'options' => [
                                                    'test' => 'validatorOptionService',
                                                    'messages' => [
                                                        'TEST' => 'validatorMessageTemplateService',
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ]
                            ],
                            HandleResponseApiMessages::class
                        ],
                    ],
                    /* */

                    ContentRedirect::class => [
                        'arguments' => [
                            GetSiteCmsResourceVersionByRequest::class,
                            FindRedirectCmsResourceVersionBySiteRequestPath::class,
                        ],
                    ],

                    /* Data Validator EXAMPLE *
                    DataZfInputFilterService::class => [
                        'arguments' => [
                            ServiceAwareFactory::class,
                            [
                                'literal' => [
                                    // zf-input-filter-service config
                                    'test1' => [
                                        'name' => 'test1',
                                        'required' => true,
                                        'validators' => [
                                            [
                                                // Invoked
                                                'name' => 'ZfInputFilterService\Validator\Test',
                                                'options' => [
                                                    'test' => 'validatorOptionInvoked',
                                                    'messages' => [
                                                        'TEST' => 'validatorMessageTemplateInvoked',
                                                    ],
                                                ],
                                            ],
                                            [
                                                // Service
                                                'name' => 'ZfInputFilterService\Validator\TestService',
                                                'service' => true,
                                                'options' => [
                                                    'test' => 'validatorOptionService',
                                                    'messages' => [
                                                        'TEST' => 'validatorMessageTemplateService',
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ]
                            ],
                            HandleResponseApiMessages::class
                        ],
                    ],
                    /* */

                    LocaleFromSite::class => [
                        'arguments' => [
                            SetLocale::class,
                            GetSiteCmsResourceVersionByRequest::class
                        ],
                    ],

                    ParamLogOut::class => [
                        'arguments' => [
                            \Zrcms\User\Api\LogOut::class,
                        ],
                    ],

                    ParamQuery::class => [],

                    /**
                     * Render ===========================================
                     */
                    ViewController::class => [
                        'arguments' => [
                            GetViewByRequest::class,
                            GetViewLayoutTags::class,
                            RenderView::class,
                            HandleResponseReturnOnStatus::class,
                        ],
                    ],
                    ViewControllerFallbackPage::class => [
                        'arguments' => [
                            FindBasicComponent::class,
                            HandleResponse::class,
                            ViewController::class,
                        ],
                    ],
                    ViewControllerTest::class => [
                        'factory' => ViewControllerTestFactory::class,
                    ],
                ],
            ],
            'routes' => [
                'zrcms.test-render' => [
                    'name' => 'zrcms.test-render',
                    'path' => '/zrcms/test-render',
                    'middleware' => ViewControllerTest::class,
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                /**
                 * Site ===========================================
                 */
                'zrcms.site.repository.find-content-version' => [
                    'name' => 'zrcms.site.repository.find-content-version',
                    'path' => '/zrcms/site/repository/find-content-version/{id}',
                    'middleware' => [
                        'acl' => AclHttp::class,
                        'api' => FindSiteVersion::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],

            'zrcms-components' => [
                'basic' => [
                    /* 'zrcms-http-expressive-1' */
                    HttpExpressiveComponent::NAME => [
                        ComponentRegistryFields::NAME
                        => HttpExpressiveComponent::NAME,

                        ComponentRegistryFields::CONFIG_LOCATION
                        => HttpExpressiveComponent::NAME,

                        ComponentRegistryFields::COMPONENT_CONFIG_READER
                        => ReadBasicComponentConfigApplicationConfig::SERVICE_ALIAS,

                        /* Map of HTTP status to the name of a SiteVersion property with the corresponding path */
                        PropertiesHttpExpressiveComponent::STATUS_TO_SITE_PATH_PROPERTY => [
                            '404' => PropertiesSiteVersion::NOT_FOUND_PAGE,
                            '401' => PropertiesSiteVersion::NOT_AUTHORIZED_PAGE,
                        ],
                    ],
                ],
                'view-layout-tags' => [
                    GetViewLayoutMetaPageData::RENDER_TAG_META_PAGE_DATA
                    => __DIR__ . '/../config/meta-page-data',
                ],
            ],

            'zrcms-service-alias' => [
                ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    GetViewLayoutMetaPageData::RENDER_TAG_META_PAGE_DATA
                    => GetViewLayoutMetaPageData::class
                ],
            ],
        ];
    }
}
