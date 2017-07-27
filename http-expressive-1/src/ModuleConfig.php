<?php

namespace Zrcms\HttpExpressive1;

use Zrcms\HttpExpressive1\Render\ViewController;
use Zrcms\HttpExpressive1\Render\ViewControllerTest;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderData;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequest;

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
                    ViewController::class => [
                        'arguments' => [
                            FindViewByRequest::class,
                            GetViewRenderData::class,
                            RenderView::class,
                        ],
                    ],
                    ViewControllerTest::class => [
                        'arguments' => [
                            GetViewRenderData::class,
                            RenderView::class,
                        ],
                    ],
                ],
            ],
            'middleware_pipeline' => [
                'always' => [
                    'middleware' => [
                        ViewControllerTest::class => ViewControllerTest::class,
                    ],
                ],
            ],
        ];
    }
}
