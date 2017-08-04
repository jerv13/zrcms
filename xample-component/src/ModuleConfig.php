<?php

namespace Zrcms\XampleComponent;

use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCore\ViewRenderDataGetter\Model\ServiceAliasViewRenderDataGetter;
use Zrcms\XampleComponent\ViewRenderDataGetter\Api\Render\GetViewRenderData;

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
                    GetViewRenderData::class => [],
                ],
            ],
            'zrcms' => [
                'blocks' => [

                ],
                'themes' => [
                    'xample-theme' => __DIR__ . '/../theme',
                ],
                'view-render-data-getters' => [
                    GetViewRenderData::XAMPLE_RENDER_TAG => __DIR__ . '/../view-render-data-getter',
                ],
            ],

            'zrcms-service-alias' => [
                /**
                 * ViewRenderDataGetter ===========================================
                 */
                ServiceAliasView::NAMESPACE_CONTENT_RENDER_DATA_GETTER  => [
                    'xample' => GetViewRenderData::class,
                ],
            ],
        ];
    }
}
