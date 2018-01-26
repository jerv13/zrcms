<?php

namespace Zrcms\HttpStatusPages;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpStatusPages\Api\GetStatusPage;
use Zrcms\HttpStatusPages\Api\GetStatusPageBasic;
use Zrcms\HttpStatusPages\Middleware\ResponseMutatorStatusPage;
use Zrcms\HttpViewRender\Response\RenderPage;

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
                    GetStatusPage::class => [
                        'class' => GetStatusPageBasic::class,
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                            FindComponent::class,
                        ],
                    ],

                    ResponseMutatorStatusPage::class => [
                        'arguments' => [
                            GetStatusPage::class,
                            RenderPage::class,
                            ['literal' => ['text/html', 'application/xhtml+xml', 'text/xml', 'application/xml', '']],
                            ['literal' => [200, 201, 204, 301, 302]],
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                ],
            ],
        ];
    }
}
