<?php

namespace Zrcms\HttpExpressive;

use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\HttpExpressive\Api\GetStatusPage;
use Zrcms\HttpExpressive\HttpRender\Acl\IsAllowedToViewPage;
use Zrcms\HttpExpressive\HttpRender\FinalHandler\NotFoundFinal;
use Zrcms\HttpExpressive\HttpRender\FinalHandler\NotFoundStatusPage;
use Zrcms\HttpExpressive\HttpRender\RenderPage;
use Zrcms\HttpExpressive\HttpRender\ResponseMutatorNoop;
use Zrcms\HttpExpressive\HttpRender\ResponseMutatorStatusPage;
use Zrcms\HttpExpressive\HttpRender\ResponseMutatorThemeLayoutWrapper;
use Zrcms\HttpExpressive\HttpRender\ResponseMutatorThemeLayoutWrapperFactory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpRenderConfig
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
                    ResponseMutatorStatusPage::class => [
                        'arguments' => [
                            GetStatusPage::class,
                            RenderPage::class,
                        ],
                    ],
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
