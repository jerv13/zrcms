<?php

namespace Zrcms\HttpAssetsAdminTools;

use Zrcms\HttpAssets\Api\Render\RenderLinkHrefTag;
use Zrcms\HttpAssets\Api\Render\RenderScriptSrcTag;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderLinkHrefTagAdminTools;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderScriptSrcTagAdminTools;
use Zrcms\HttpAssetsAdminTools\Middleware\AdminToolsBlockCss;
use Zrcms\HttpAssetsAdminTools\Middleware\AdminToolsBlockJs;

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
                'zrcms.admin-tools.block.css' => [
                    'name' => 'zrcms.admin-tools.block.css',
                    'path' => '/zrcms/admin-tools/block.css',
                    'middleware' => [
                        'middleware' => AdminToolsBlockCss::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                'zrcms.admin-tools.block.js' => [
                    'name' => 'zrcms.admin-tools.block.js',
                    'path' => '/zrcms/admin-tools/block.js',
                    'middleware' => [
                        'middleware' => AdminToolsBlockJs::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],

            'zrcms-view-head.head-link' => [
                'sections' => [
                    'modules' => [
                        'zrcms.admin-tools.block.css' => [
                            '__render_service' => RenderLinkHrefTagAdminTools::class,
                            RenderLinkHrefTag::OPTION_HREF_ATTRIBUTE => '/zrcms/admin-tools/block.css',
                        ],
                    ],
                ],
            ],

            'zrcms-view-head.head-script' => [
                'sections' => [
                    'modules' => [
                        'zrcms.admin-tools.block.js' => [
                            '__render_service' => RenderScriptSrcTagAdminTools::class,
                            RenderScriptSrcTag::OPTION_SRC_ATTRIBUTE => '/zrcms/admin-tools/block.js',
                        ],
                    ],
                ],
            ],
        ];
    }
}
