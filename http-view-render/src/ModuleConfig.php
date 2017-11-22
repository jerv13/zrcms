<?php

namespace Zrcms\HttpViewRender;

use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\HttpStatusPages\Api\GetStatusPage;
use Zrcms\HttpViewRender\Request\RequestWithOriginalUri;
use Zrcms\HttpViewRender\Request\RequestWithView;
use Zrcms\HttpViewRender\Request\RequestWithViewRenderPage;
use Zrcms\HttpViewRender\Acl\IsAllowedToViewPage;
use Zrcms\HttpViewRender\FinalHandler\NotFoundFinal;
use Zrcms\HttpViewRender\FinalHandler\NotFoundStatusPage;
use Zrcms\HttpViewRender\Response\RenderPage;
use Zrcms\HttpViewRender\Response\ResponseMutatorNoop;
use Zrcms\HttpViewRender\Response\ResponseMutatorThemeLayoutWrapper;
use Zrcms\HttpViewRender\Response\ResponseMutatorThemeLayoutWrapperFactory;

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
                     * Acl ===========================================
                     */
                    /* ACL EXAMPLE *
                    IsAllowedCheck::class => [
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
                    IsAllowedToViewPage::class => [],

                    /**
                     * FinalHandler ===========================================
                     */
                    NotFoundFinal::class => [],

                    NotFoundStatusPage::class => [
                        'arguments' => [
                            GetStatusPage::class,
                            RenderPage::class,
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
                     * General ===========================================
                     */
                    RenderPage::class => [
                        'arguments' => [
                            GetViewByRequest::class,
                            GetViewLayoutTags::class,
                            RenderView::class,
                        ],
                    ],
                    ResponseMutatorNoop::class => [],

                    ResponseMutatorThemeLayoutWrapper::class => [
                        'factory' => ResponseMutatorThemeLayoutWrapperFactory::class,
                    ],
                ],
            ],
            'zrcms-http-render-layout-for-path' => [
                /** ['/my-path' => {bool:addLayout}] */
            ],
        ];
    }
}
