<?php

namespace Zrcms\ViewMetaPageData;

use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\ViewMetaPageData\Api\View\Render\GetViewLayoutMetaPageData;

/**
 * @deprecated BC ONLY - Use \Zrcms\HttpApplicationState
 * @author     James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
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
