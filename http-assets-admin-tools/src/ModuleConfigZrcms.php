<?php

namespace Zrcms\HttpAssetsAdminTools;

use Zrcms\HttpAssets\Api\Render\RenderLinkHrefTag;
use Zrcms\HttpAssets\Api\Render\RenderScriptSrcTag;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderLinkHrefTagAdminTools;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderScriptSrcTagAdminTools;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
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
                        'zrcms.admin-tools.block.css' => [
                            'renderer' => 'render-service',
                            '__render_service' => RenderLinkHrefTagAdminTools::class,
                            RenderLinkHrefTag::OPTION_HREF_ATTRIBUTE => '/zrcms/admin-tools/block.css',
                        ],
                    ],
                ],
            ],

            'zrcms-view-head.head-script' => [
                'sections' => [
                    'libraries' => [
                        'zrcms.admin-tools.bundle-admin-tools.js' => [
                            'renderer' => 'render-service',
                            '__render_service' => RenderScriptSrcTagAdminTools::class,
                            // @todo This is subject to change and may not be the final path
                            RenderScriptSrcTag::OPTION_SRC_ATTRIBUTE => '/dist/bundle-admin-tools.js',
                        ],
                    ],
                    'modules' => [
                        'zrcms.admin-tools.block.js' => [
                            'renderer' => 'render-service',
                            '__render_service' => RenderScriptSrcTagAdminTools::class,
                            RenderScriptSrcTag::OPTION_SRC_ATTRIBUTE => '/zrcms/admin-tools/block.js',
                        ],
                    ],
                ],
            ],
        ];
    }
}
