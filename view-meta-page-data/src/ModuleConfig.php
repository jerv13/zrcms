<?php

namespace Zrcms\ViewMetaPageData;

use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\Debug\IsDebug;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;
use Zrcms\ViewMetaPageData\Api\View\Render\GetViewLayoutMetaPageData;

/**
 * @deprecated BC ONLY - Use \Zrcms\HttpAssetsApplicationState
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
                     * Api ===========================================
                     */
                    GetViewLayoutMetaPageData::class => [
                        'arguments' => [
                            RenderTag::class,
                            // @todo Real ACL??
                            IsAllowedAny::class,
                            ['literal' => []],
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                ],
            ],

            'zrcms-components' => [
                'view-layout-tag.meta-page-data'
                => 'json:' . __DIR__ . '/../view-layout-tags.json',
            ],

            'zrcms-service-alias' => [
                ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    GetViewLayoutMetaPageData::RENDER_TAG_META_PAGE_DATA
                    => GetViewLayoutMetaPageData::class
                ],
            ],
        ];
    }
}
