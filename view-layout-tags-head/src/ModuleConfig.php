<?php

namespace Zrcms\ViewLayoutTagsHead\Head;

use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHead;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHeadAll;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHeadLink;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHeadMeta;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHeadScript;
use Zrcms\ViewLayoutTagsHead\Api\Render\GetViewRenderTagsHeadTitle;

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
                    GetViewRenderTagsHead::class => [
                        'class' => GetViewRenderTagsHeadAll::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetViewRenderTagsHeadAll::class => [
                        'class' => GetViewRenderTagsHeadAll::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetViewRenderTagsHeadLink::class => [],
                    GetViewRenderTagsHeadMeta::class => [],
                    GetViewRenderTagsHeadScript::class => [],
                    GetViewRenderTagsHeadTitle::class => [],
                ],
            ],
            'zrcms' => [
                'view-layout-tags-getters' => [
                    'head-all' => __DIR__ . '/../../config/head-all',
                    'head-link' => __DIR__ . '/../../config/head-link',
                    'head-meta' => __DIR__ . '/../../config/head-meta',
                    'head-script' => __DIR__ . '/../../config/head-script',
                    'head-title' => __DIR__ . '/../../config/head-title',
                ],
            ],

            'zrcms-service-alias' => [
                ServiceAliasView::NAMESPACE_CONTENT_RENDER_TAGS_GETTER => [
                    GetViewRenderTagsHeadAll::SERVICE_ALIAS => GetViewRenderTagsHeadAll::class,
                    GetViewRenderTagsHeadLink::SERVICE_ALIAS => GetViewRenderTagsHeadLink::class,
                    GetViewRenderTagsHeadMeta::SERVICE_ALIAS => GetViewRenderTagsHeadMeta::class,
                    GetViewRenderTagsHeadScript::SERVICE_ALIAS => GetViewRenderTagsHeadScript::class,
                    GetViewRenderTagsHeadTitle::SERVICE_ALIAS => GetViewRenderTagsHeadTitle::class,
                ],
            ]
        ];
    }
}
