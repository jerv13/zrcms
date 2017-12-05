<?php

namespace Zrcms\XampleComponent;

use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\XampleComponent\View\Api\Render\GetViewLayoutTags;

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
                    GetViewLayoutTags::class => [],
                ],
            ],
            'zrcms-components' => [
                'blocks' => [
                    'xample'
                    => __DIR__ . '/../block/block.json',
                ],
                'themes' => [
                    'xample-theme'
                    => __DIR__ . '/../theme/theme.json',
                ],
                'view-layout-tags' => [
                    'xample' // GetViewLayoutTags::XAMPLE_RENDER_TAG
                    => __DIR__ . '/../view-layout-tags/view-layout-tags.json',
                ],
            ],

            'zrcms-service-alias' => [
                /**
                 * ViewLayoutTagsGetter ===========================================
                 */
                ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    'xample' => GetViewLayoutTags::class,
                ],
            ],
        ];
    }
}
