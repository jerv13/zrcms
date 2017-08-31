<?php

namespace Zrcms\HttpExpressive1;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigApplicationConfig;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceVersionByRequest;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;
use Zrcms\ContentRedirectDoctrineDataSource\Api\Repository\FindRedirectCmsResourceVersionBySiteRequestPath;
use Zrcms\HttpExpressive1\Api\View\Render\GetViewLayoutMetaPageData;
use Zrcms\HttpExpressive1\HttpAlways\ContentRedirect;
use Zrcms\HttpExpressive1\HttpAlways\LocaleFromSite;
use Zrcms\HttpExpressive1\HttpAlways\ParamLogOut;
use Zrcms\HttpExpressive1\HttpParams\ParamQuery;
use Zrcms\HttpExpressive1\HttpRender\ViewController;
use Zrcms\HttpExpressive1\HttpRender\ViewControllerFallbackPage;
use Zrcms\HttpExpressive1\HttpRender\ViewControllerTest;
use Zrcms\HttpExpressive1\HttpRender\ViewControllerTestFactory;
use Zrcms\HttpExpressive1\HttpValidator\IdAttributeZfInputFilterService;
use Zrcms\HttpExpressive1\Model\HttpExpressiveComponent;
use Zrcms\HttpExpressive1\Model\PropertiesHttpExpressiveComponent;
use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\Locale\Api\SetLocale;
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
                     * HttpAcl ===========================================
                     */
                    /* ACL EXAMPLE *
                    IsAllowedCheck::class => [
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

                    /**
                     * HttpAlways ===========================================
                     */
                    ContentRedirect::class => [
                        'arguments' => [
                            GetSiteCmsResourceVersionByRequest::class,
                            FindRedirectCmsResourceVersionBySiteRequestPath::class,
                        ],
                    ],

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

                    /**
                     * HttpParams ===========================================
                     */
                    ParamQuery::class => [],

                    /**
                     * HttpRender ===========================================
                     */
                    ViewController::class => [
                        'arguments' => [
                            GetViewByRequest::class,
                            GetViewLayoutTags::class,
                            RenderView::class,
                            HandleResponse::class,
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

                    /**
                     * HttpValidator ===========================================
                     */
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

                    IdAttributeZfInputFilterService::class => [
                        'arguments' => [
                            ServiceAwareFactory::class,
                            HandleResponseApi::class,
                            ['literal' => 'id'],
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
