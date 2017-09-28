<?php

namespace Zrcms\HttpExpressive1;

use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Api\GetViewByRequestHtmlPage;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\HttpExpressive1\Api\GetStatusPage;
use Zrcms\HttpExpressive1\HttpRender\Acl\IsAllowedToViewPage;
use Zrcms\HttpExpressive1\HttpRender\FinalHandler\NotFoundFinal;
use Zrcms\HttpExpressive1\HttpRender\FinalHandler\NotFoundStatusPage;
use Zrcms\HttpExpressive1\HttpRender\RenderPage;
use Zrcms\HttpExpressive1\HttpRender\ResponseMutatorNoop;
use Zrcms\HttpExpressive1\HttpRender\ResponseMutatorStatusPage;
use Zrcms\HttpExpressive1\HttpRender\ResponseMutatorThemeLayoutWrapper;

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
                        'arguments' => [
                            GetViewByRequestHtmlPage::class,
                            GetViewLayoutTags::class,
                            RenderView::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
