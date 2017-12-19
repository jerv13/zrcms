<?php

namespace Zrcms\HttpAssetsBlock;

use Zrcms\HttpAssets\Api\Render\RenderLinkHrefTag;
use Zrcms\HttpAssets\Api\Render\RenderScriptSrcTag;
use Zrcms\HttpAssetsBlock\Middleware\BlockCss;
use Zrcms\HttpAssetsBlock\Middleware\BlockJs;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigRoutes
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [
                'zrcms.block.block.css' => [
                    'name' => 'zrcms.block.block.css',
                    'path' => '/zrcms/block/block.css',
                    'middleware' => [
                        'middleware' => BlockCss::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                'zrcms.block.block.js' => [
                    'name' => 'zrcms.block.block.js',
                    'path' => '/zrcms/block/block.js',
                    'middleware' => [
                        'middleware' => BlockJs::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],

            'zrcms-view-head.head-link' => [
                'sections' => [
                    'modules' => [
                        'zrcms.block.block.css' => [
                            '__render_service' => RenderLinkHrefTag::class,
                            RenderLinkHrefTag::OPTION_HREF_ATTRIBUTE => '/zrcms/block/block.css',
                        ],
                    ],
                ],
            ],

            'zrcms-view-head.head-script' => [
                'sections' => [
                    'modules' => [
                        'zrcms.block.block.js' => [
                            '__render_service' => RenderScriptSrcTag::class,
                            RenderScriptSrcTag::OPTION_SRC_ATTRIBUTE => '/zrcms/block/block.js',
                        ],
                    ],
                ],
            ],
        ];
    }
}
