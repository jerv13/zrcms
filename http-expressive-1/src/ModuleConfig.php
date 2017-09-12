<?php

namespace Zrcms\HttpExpressive1;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigApplicationConfig;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceByRequest;
use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;
use Zrcms\ContentRedirect\Api\Repository\FindRedirectCmsResourceBySiteRequestPath;
use Zrcms\HttpExpressive1\Api\GetStatusPage;
use Zrcms\HttpExpressive1\Api\GetStatusPageBasic;
use Zrcms\HttpExpressive1\Api\View\Render\GetViewLayoutMetaPageData;
use Zrcms\HttpExpressive1\HttpAcl\IsAllowedToViewPage;
use Zrcms\HttpExpressive1\HttpAlways\ContentRedirect;
use Zrcms\HttpExpressive1\HttpAlways\LocaleFromSite;
use Zrcms\HttpExpressive1\HttpAlways\ParamLogOut;
use Zrcms\HttpExpressive1\HttpAlways\RequestWithOriginalUri;
use Zrcms\HttpExpressive1\HttpAlways\RequestWithView;
use Zrcms\HttpExpressive1\HttpAlways\RequestWithViewRenderPage;
use Zrcms\HttpExpressive1\HttpFinal\NotFoundStatusPage;
use Zrcms\HttpExpressive1\HttpParams\ParamQuery;
use Zrcms\HttpExpressive1\HttpRender\RenderPage;
use Zrcms\HttpExpressive1\HttpResponseMutator\ResponseMutator;
use Zrcms\HttpExpressive1\HttpResponseMutator\ResponseMutatorNoop;
use Zrcms\HttpExpressive1\HttpResponseMutator\ResponseMutatorStatusPage;
use Zrcms\HttpExpressive1\HttpValidator\IdAttributeZfInputFilterService;
use Zrcms\HttpExpressive1\Model\HttpExpressiveComponent;
use Zrcms\HttpExpressive1\Model\PropertiesHttpExpressiveComponent;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\Locale\Api\SetLocale;
use Zrcms\User\Api\LogOut;
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
                            // @todo Real ACL??
                            IsAllowedAny::class,
                            [
                                'literal' => [
                                    //IsAllowedRcmUser::OPTION_RESOURCE_ID => 'sites',
                                    //IsAllowedRcmUser::OPTION_PRIVILEGE => 'admin',
                                ]
                            ],
                        ],
                    ],

                    GetStatusPage::class => [
                        'class' => GetStatusPageBasic::class,
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                            FindBasicComponent::class,
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

                    IsAllowedToViewPage::class => [],

                    /**
                     * HttpAlways ===========================================
                     */
                    ContentRedirect::class => [
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                            FindRedirectCmsResourceBySiteRequestPath::class,
                        ],
                    ],

                    LocaleFromSite::class => [
                        'arguments' => [
                            SetLocale::class,
                            GetSiteCmsResourceByRequest::class
                        ],
                    ],

                    ParamLogOut::class => [
                        'arguments' => [
                            LogOut::class,
                        ],
                    ],

                    RequestWithOriginalUri::class => [],

                    RequestWithViewRenderPage::class => [
                        'arguments' => [
                            GetViewLayoutTags::class,
                            RenderView::class,
                        ],
                    ],

                    RequestWithView::class => [
                        'arguments' => [
                            GetViewByRequest::class,
                        ],
                    ],
                    /**
                     * HttpFinal ===========================================
                     */
                    NotFoundStatusPage::class => [
                        'arguments' => [
                            GetStatusPage::class,
                            RenderPage::class,
                        ],
                    ],

                    /**
                     * HttpParams ===========================================
                     */
                    ParamQuery::class => [],

                    /**
                     * HttpRender ===========================================
                     */
                    RenderPage::class => [
                        'arguments' => [
                            GetViewByRequest::class,
                            GetViewLayoutTags::class,
                            RenderView::class,
                        ],
                    ],

                    /**
                     * ResponseMutator ===========================================
                     */
                    ResponseMutator::class => [
                        //'class' => ResponseMutatorNoop::class,
                        // @todo This should use ResponseMutatorStatusPage by default
                        'class' => ResponseMutatorStatusPage::class,
                        'arguments' => [
                            GetStatusPage::class,
                            RenderPage::class,
                        ],
                    ],
                    ResponseMutatorNoop::class => [],
                    ResponseMutatorStatusPage::class => [
                        'arguments' => [
                            GetStatusPage::class,
                            RenderPage::class,
                        ],
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

                    ApplicationZrcms::class => [
                        'factory' => ApplicationZrcmsFullFactory::class,
                    ],
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

                        ComponentRegistryFields::COMPONENT_CLASS
                        => HttpExpressiveComponent::class,

                        /* Map of HTTP status to the name of a SiteVersion property with the corresponding path */
                        PropertiesHttpExpressiveComponent::STATUS_TO_SITE_PATH_PROPERTY => [
                            '401' => [
                                'path' => '/not-authorized',
                                'type' => 'render',
                            ],
                            '404' => [
                                'path' => '/not-found',
                                'type' => 'render',
                            ],
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
