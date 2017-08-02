<?php

namespace Zrcms\ViewRenderDataGetters\Head;

use Zrcms\ViewRenderDataGetters\Head\Api\Render\GetViewRenderDataHead;
use Zrcms\ViewRenderDataGetters\Head\Api\Render\GetViewRenderDataHeadAll;
use Zrcms\ViewRenderDataGetters\Head\Api\Render\GetViewRenderDataHeadAllFactory;
use Zrcms\ViewRenderDataGetters\Head\Api\Render\GetViewRenderDataHeadLink;
use Zrcms\ViewRenderDataGetters\Head\Api\Render\GetViewRenderDataHeadMeta;
use Zrcms\ViewRenderDataGetters\Head\Api\Render\GetViewRenderDataHeadScript;
use Zrcms\ViewRenderDataGetters\Head\Api\Render\GetViewRenderDataHeadTitle;

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
                    GetViewRenderDataHead::class => [
                        'factory' => GetViewRenderDataHeadAllFactory::class,
                    ],
                    GetViewRenderDataHeadAll::class => [
                        'factory' => GetViewRenderDataHeadAllFactory::class,
                    ],
                    GetViewRenderDataHeadLink::class => [],
                    GetViewRenderDataHeadMeta::class => [],
                    GetViewRenderDataHeadScript::class => [],
                    GetViewRenderDataHeadTitle::class => [],
                ],
            ],
            'zrcms' => [
                'view-render-data-getters' => [
                    'head-all' => __DIR__ . '/../../config/head-all',
                    'head-link' => __DIR__ . '/../../config/head-link',
                    'head-meta' => __DIR__ . '/../../config/head-meta',
                    'head-script' => __DIR__ . '/../../config/head-script',
                    'head-title' => __DIR__ . '/../../config/head-title',
                ],
            ],
        ];
    }
}
