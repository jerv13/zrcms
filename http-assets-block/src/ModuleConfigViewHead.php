<?php

namespace Zrcms\HttpAssetsBlock;

use Zrcms\HttpAssets\Api\Render\RenderLinkHrefTag;
use Zrcms\HttpAssets\Api\Render\RenderScriptSrcTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigViewHead
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'zrcms-view-head.head-link' => [
                'sections' => [
                    'modules' => [
                        'zrcms.block.block.css' => [
                            '__render_service' => RenderLinkHrefTag::class,
                            RenderLinkHrefTag::OPTION_HREF_ATTRIBUTE => '/zrcms/component/block.css',
                        ],
                    ],
                ],
            ],

            'zrcms-view-head.head-script' => [
                'sections' => [
                    'modules' => [
                        'zrcms.block.block.js' => [
                            '__render_service' => RenderScriptSrcTag::class,
                            RenderScriptSrcTag::OPTION_SRC_ATTRIBUTE => '/zrcms/component/block.js',
                        ],
                    ],
                ],
            ],
        ];
    }
}
