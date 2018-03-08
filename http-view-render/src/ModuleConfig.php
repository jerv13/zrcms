<?php

namespace Zrcms\HttpViewRender;

use Zrcms\HttpViewRender\Acl\HttpIsAllowedViewStrategyPageVersionId;
use Zrcms\HttpViewRender\Acl\HttpIsAllowedViewStrategyPageVersionIdFactory;
use Zrcms\HttpViewRender\Acl\HttpIsAllowedViewStrategyPublishedAny;
use Zrcms\HttpViewRender\Acl\HttpIsAllowedViewStrategyPublishedAnyFactory;
use Zrcms\HttpViewRender\FinalHandler\HttpNotFoundFinal;
use Zrcms\HttpViewRender\FinalHandler\HttpNotFoundFinalFactory;
use Zrcms\HttpViewRender\FinalHandler\HttpNotFoundStatusPage;
use Zrcms\HttpViewRender\FinalHandler\HttpNotFoundStatusPageFactory;
use Zrcms\HttpViewRender\Request\RequestWithIdentifier;
use Zrcms\HttpViewRender\Request\RequestWithIdentifierFactory;
use Zrcms\HttpViewRender\Request\RequestWithOriginalUri;
use Zrcms\HttpViewRender\Request\RequestWithOriginalUriFactory;
use Zrcms\HttpViewRender\Request\RequestWithView;
use Zrcms\HttpViewRender\Request\RequestWithViewFactory;
use Zrcms\HttpViewRender\Request\RequestWithViewRenderPage;
use Zrcms\HttpViewRender\Request\RequestWithViewRenderPageFactory;
use Zrcms\HttpViewRender\Request\RequestWithViewStrategyDefaultPublishedAny;
use Zrcms\HttpViewRender\Request\RequestWithViewStrategyDefaultPublishedAnyFactory;
use Zrcms\HttpViewRender\Request\RequestWithViewStrategyPageVersionId;
use Zrcms\HttpViewRender\Request\RequestWithViewStrategyPageVersionIdFactory;
use Zrcms\HttpViewRender\Response\RenderPage;
use Zrcms\HttpViewRender\Response\RenderPageFactory;
use Zrcms\HttpViewRender\Response\ResponseMutatorNoop;
use Zrcms\HttpViewRender\Response\ResponseMutatorThemeLayoutWrapper;
use Zrcms\HttpViewRender\Response\ResponseMutatorThemeLayoutWrapperFactory;
use Zrcms\HttpViewRender\Router\LayoutThemeRouter;
use Zrcms\HttpViewRender\Router\LayoutThemeRouterFastRouteFactory;

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
                    /* ACL EXAMPLE *
                    HttpIsAllowed::class => [
                        'arguments' => [
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

                    HttpIsAllowedViewStrategyPageVersionId::class => [
                        'factory' => HttpIsAllowedViewStrategyPageVersionIdFactory::class,
                    ],

                    HttpIsAllowedViewStrategyPublishedAny::class => [
                        'factory' => HttpIsAllowedViewStrategyPublishedAnyFactory::class,
                    ],

                    /**
                     * FinalHandler ===========================================
                     */
                    HttpNotFoundFinal::class => [
                        'factory' => HttpNotFoundFinalFactory::class,
                    ],

                    HttpNotFoundStatusPage::class => [
                        'factory' => HttpNotFoundStatusPageFactory::class,
                    ],

                    /**
                     * Request ===========================================
                     */
                    RequestWithIdentifier::class => [
                        'factory' => RequestWithIdentifierFactory::class,
                    ],

                    RequestWithOriginalUri::class => [
                        'factory' => RequestWithOriginalUriFactory::class,
                    ],

                    RequestWithView::class => [
                        'factory' => RequestWithViewFactory::class,
                    ],

                    RequestWithViewRenderPage::class => [
                        'factory' => RequestWithViewRenderPageFactory::class,
                    ],

                    RequestWithViewStrategyDefaultPublishedAny::class => [
                        'factory' => RequestWithViewStrategyDefaultPublishedAnyFactory::class,
                    ],

                    RequestWithViewStrategyPageVersionId::class => [
                        'factory' => RequestWithViewStrategyPageVersionIdFactory::class,
                    ],

                    /**
                     * Response ===========================================
                     */
                    RenderPage::class => [
                        'factory' => RenderPageFactory::class,
                    ],
                    ResponseMutatorNoop::class => [],

                    ResponseMutatorThemeLayoutWrapper::class => [
                        'factory' => ResponseMutatorThemeLayoutWrapperFactory::class,
                    ],

                    LayoutThemeRouter::class => [
                        'factory' => LayoutThemeRouterFastRouteFactory::class
                    ],
                ],
            ],
        ];
    }
}
