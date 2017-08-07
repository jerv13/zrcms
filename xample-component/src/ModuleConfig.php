<?php

namespace Zrcms\XampleComponent;

use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCore\ViewLayoutTags\Model\ServiceAliasViewLayoutTagsGetter;
use Zrcms\XampleComponent\ViewLayoutTags\Api\Render\GetViewLayoutTags;

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
            'zrcms' => [
                'blocks' => [
                    'xample' => __DIR__ . '/../block',
                ],
                'themes' => [
                    'xample-theme' => __DIR__ . '/../theme',
                ],
                'view-layout-tags-getters' => [
                    GetViewLayoutTags::XAMPLE_RENDER_TAG => __DIR__ . '/../view-layout-tags-getter',
                ],
            ],

            'zrcms-service-alias' => [
                /**
                 * ViewLayoutTagsGetter ===========================================
                 */
                ServiceAliasView::NAMESPACE_CONTENT_RENDER_TAGS_GETTER  => [
                    'xample' => GetViewLayoutTags::class,
                ],
            ],
        ];
    }
}
