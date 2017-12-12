<?php

namespace Zrcms\XampleComponent;

use Zrcms\Core\Fields\FieldsComponentRegistry;
use Zrcms\CoreView\Model\ServiceAliasView;
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
                'block.zrcms-xample'
                => 'json:' . __DIR__ . '/../block/block.json',

                'theme.zrcms-xample'
                => 'json:' . __DIR__ . '/../theme/theme.json',

                'theme-layout.zrcms-xample.layout-one'
                => 'json:' . __DIR__ . '/../theme/layout-one/layout.json',
                'theme-layout.zrcms-xample.primary'
                => 'json:' . __DIR__ . '/../theme/layout-primary/layout.json',

                'view-layout-tag.zrcms-xample'
                => 'json:' . __DIR__ . '/../view-layout-tags/view-layout-tags.json',
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
