<?php

namespace Zrcms\ViewLayoutTagsHead;

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
                'view-layout-tags' => [
                    GetViewRenderTagsHeadAll::RENDER_TAG_ALL => __DIR__ . '/../config/head-all',
                    GetViewRenderTagsHeadLink::RENDER_TAG_LINK => __DIR__ . '/../config/head-link',
                    GetViewRenderTagsHeadMeta::RENDER_TAG_META => __DIR__ . '/../config/head-meta',
                    GetViewRenderTagsHeadScript::RENDER_TAG_SCRIPT => __DIR__ . '/../config/head-script',
                    GetViewRenderTagsHeadTitle::RENDER_TAG_TITLE => __DIR__ . '/../config/head-title',
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
