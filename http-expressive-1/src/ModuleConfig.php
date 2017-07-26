<?php

namespace Zrcms\HttpExpressive1;

use Zrcms\ContentCore\PageView\Middleware\ViewController;
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
                ],
            ],
        ];
    }
}
