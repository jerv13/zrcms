<?php

namespace Zrcms\XampleComponent;

use Zrcms\Content\Fields\FieldsComponentRegistry;
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
                'block.zrcms-xample' => [
                    FieldsComponentRegistry::TYPE => 'block',
                    FieldsComponentRegistry::NAME => 'zrcms-xample',
                    FieldsComponentRegistry::CONFIG_LOCATION => __DIR__ . '/../block/block.json',
                    FieldsComponentRegistry::MODULE_DIRECTORY
                    => __DIR__ . '/../block',
                ],
                'theme.zrcms-xample' => [
                    FieldsComponentRegistry::TYPE => 'theme',
                    FieldsComponentRegistry::NAME => 'zrcms-xample',
                    FieldsComponentRegistry::CONFIG_LOCATION => __DIR__ . '/../theme/theme.json',
                    FieldsComponentRegistry::MODULE_DIRECTORY
                    => __DIR__ . '/../theme',
                ],
                'view-layout-tag.zrcms-xample' => [
                    FieldsComponentRegistry::TYPE => 'view-layout-tag',
                    FieldsComponentRegistry::NAME => 'zrcms-xample',
                    FieldsComponentRegistry::CONFIG_LOCATION => __DIR__ . '/../view-layout-tags/view-layout-tags.json',
                    FieldsComponentRegistry::MODULE_DIRECTORY
                    => __DIR__ . '/../view-layout-tags',
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
